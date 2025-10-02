<?php
namespace PhpOffice\PhpSpreadsheet\Calculationparts2;

use PhpOffice\PhpSpreadsheet\Calculation\Engine\BranchPruner;
use PhpOffice\PhpSpreadsheet\Calculation\Engine\CyclicReferenceStack;
use PhpOffice\PhpSpreadsheet\Calculation\Engine\Logger;
use PhpOffice\PhpSpreadsheet\Calculation\Engine\Operands;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;
use PhpOffice\PhpSpreadsheet\Calculation\Token\Stack;
use PhpOffice\PhpSpreadsheet\Cell\AddressRange;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\DefinedName;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\ReferenceHelper;
use PhpOffice\PhpSpreadsheet\Shared;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use ReflectionClassConstant;
use ReflectionMethod;
use ReflectionParameter;
use Throwable;
class Calculationparts2
{
// Convert infix to postfix notation

    /**
     * @return array<int, mixed>|false
     */
    private function internalParseFormula(string $formula, ?Cell $cell = null): bool|array
    {
        if (($formula = $this->convertMatrixReferences(trim($formula))) === false) {
            return false;
        }

        //    If we're using cell caching, then $pCell may well be flushed back to the cache (which detaches the parent worksheet),
        //        so we store the parent worksheet so that we can re-attach it when necessary
        $pCellParent = ($cell !== null) ? $cell->getWorksheet() : null;

        $regexpMatchString = '/^((?<string>' . self::CALCULATION_REGEXP_STRING
                                . ')|(?<function>' . self::CALCULATION_REGEXP_FUNCTION
                                . ')|(?<cellRef>' . self::CALCULATION_REGEXP_CELLREF
                                . ')|(?<colRange>' . self::CALCULATION_REGEXP_COLUMN_RANGE
                                . ')|(?<rowRange>' . self::CALCULATION_REGEXP_ROW_RANGE
                                . ')|(?<number>' . self::CALCULATION_REGEXP_NUMBER
                                . ')|(?<openBrace>' . self::CALCULATION_REGEXP_OPENBRACE
                                . ')|(?<structuredReference>' . self::CALCULATION_REGEXP_STRUCTURED_REFERENCE
                                . ')|(?<definedName>' . self::CALCULATION_REGEXP_DEFINEDNAME
                                . ')|(?<error>' . self::CALCULATION_REGEXP_ERROR
                                . '))/sui';

        //    Start with initialisation
        $index = 0;
        $stack = new Stack($this->branchPruner);
        $output = [];
        $expectingOperator = false; //    We use this test in syntax-checking the expression to determine when a
        //        - is a negation or + is a positive operator rather than an operation
        $expectingOperand = false; //    We use this test in syntax-checking the expression to determine whether an operand
        //        should be null in a function call

        //    The guts of the lexical parser
        //    Loop through the formula extracting each operator and operand in turn
        while (true) {
            // Branch pruning: we adapt the output item to the context (it will
            // be used to limit its computation)
            $this->branchPruner->initialiseForLoop();

            $opCharacter = $formula[$index]; //    Get the first character of the value at the current index position

            // Check for two-character operators (e.g. >=, <=, <>)
            if ((isset(self::$comparisonOperators[$opCharacter])) && (strlen($formula) > $index) && isset($formula[$index + 1], self::$comparisonOperators[$formula[$index + 1]])) {
                $opCharacter .= $formula[++$index];
            }
            //    Find out if we're currently at the beginning of a number, variable, cell/row/column reference,
            //         function, defined name, structured reference, parenthesis, error or operand
            $isOperandOrFunction = (bool) preg_match($regexpMatchString, substr($formula, $index), $match);

            $expectingOperatorCopy = $expectingOperator;
            if ($opCharacter === '-' && !$expectingOperator) {                //    Is it a negation instead of a minus?
                //    Put a negation on the stack
                $stack->push('Unary Operator', '~');
                ++$index; //        and drop the negation symbol
            } elseif ($opCharacter === '%' && $expectingOperator) {
                //    Put a percentage on the stack
                $stack->push('Unary Operator', '%');
                ++$index;
            } elseif ($opCharacter === '+' && !$expectingOperator) {            //    Positive (unary plus rather than binary operator plus) can be discarded?
                ++$index; //    Drop the redundant plus symbol
            } elseif ((($opCharacter === '~') || ($opCharacter === '∩') || ($opCharacter === '∪')) && (!$isOperandOrFunction)) {
                //    We have to explicitly deny a tilde, union or intersect because they are legal
                return $this->raiseFormulaError("Formula Error: Illegal character '~'"); //        on the stack but not in the input expression
            } elseif ((isset(self::CALCULATION_OPERATORS[$opCharacter]) || $isOperandOrFunction) && $expectingOperator) {    //    Are we putting an operator on the stack?
                while (
                    $stack->count() > 0
                    && ($o2 = $stack->last())
                    && isset(self::CALCULATION_OPERATORS[$o2['value']])
                    && @(self::$operatorAssociativity[$opCharacter] ? self::$operatorPrecedence[$opCharacter] < self::$operatorPrecedence[$o2['value']] : self::$operatorPrecedence[$opCharacter] <= self::$operatorPrecedence[$o2['value']])
                ) {
                    $output[] = $stack->pop(); //    Swap operands and higher precedence operators from the stack to the output
                }

                //    Finally put our current operator onto the stack
                $stack->push('Binary Operator', $opCharacter);

                ++$index;
                $expectingOperator = false;
            } elseif ($opCharacter === ')' && $expectingOperator) { //    Are we expecting to close a parenthesis?
                $expectingOperand = false;
                while (($o2 = $stack->pop()) && $o2['value'] !== '(') { //    Pop off the stack back to the last (
                    $output[] = $o2;
                }
                $d = $stack->last(2);

                // Branch pruning we decrease the depth whether is it a function
                // call or a parenthesis
                $this->branchPruner->decrementDepth();

                if (is_array($d) && preg_match('/^' . self::CALCULATION_REGEXP_FUNCTION . '$/miu', $d['value'], $matches)) {
                    //    Did this parenthesis just close a function?
                    try {
                        $this->branchPruner->closingBrace($d['value']);
                    } catch (Exception $e) {
                        return $this->raiseFormulaError($e->getMessage(), $e->getCode(), $e);
                    }

                    $functionName = $matches[1]; //    Get the function name
                    $d = $stack->pop();
                    $argumentCount = $d['value'] ?? 0; //    See how many arguments there were (argument count is the next value stored on the stack)
                    $output[] = $d; //    Dump the argument count on the output
                    $output[] = $stack->pop(); //    Pop the function and push onto the output
                    if (isset(self::$controlFunctions[$functionName])) {
                        $expectedArgumentCount = self::$controlFunctions[$functionName]['argumentCount'];
                    } elseif (isset(self::$phpSpreadsheetFunctions[$functionName])) {
                        $expectedArgumentCount = self::$phpSpreadsheetFunctions[$functionName]['argumentCount'];
                    } else {    // did we somehow push a non-function on the stack? this should never happen
                        return $this->raiseFormulaError('Formula Error: Internal error, non-function on stack');
                    }
                    //    Check the argument count
                    $argumentCountError = false;
                    $expectedArgumentCountString = null;
                    if (is_numeric($expectedArgumentCount)) {
                        if ($expectedArgumentCount < 0) {
                            if ($argumentCount > abs($expectedArgumentCount)) {
                                $argumentCountError = true;
                                $expectedArgumentCountString = 'no more than ' . abs($expectedArgumentCount);
                            }
                        } else {
                            if ($argumentCount != $expectedArgumentCount) {
                                $argumentCountError = true;
                                $expectedArgumentCountString = $expectedArgumentCount;
                            }
                        }
                    } elseif ($expectedArgumentCount != '*') {
                        preg_match('/(\d*)([-+,])(\d*)/', $expectedArgumentCount, $argMatch);
                        switch ($argMatch[2] ?? '') {
                            case '+':
                                if ($argumentCount < $argMatch[1]) {
                                    $argumentCountError = true;
                                    $expectedArgumentCountString = $argMatch[1] . ' or more ';
                                }

                                break;
                            case '-':
                                if (($argumentCount < $argMatch[1]) || ($argumentCount > $argMatch[3])) {
                                    $argumentCountError = true;
                                    $expectedArgumentCountString = 'between ' . $argMatch[1] . ' and ' . $argMatch[3];
                                }

                                break;
                            case ',':
                                if (($argumentCount != $argMatch[1]) && ($argumentCount != $argMatch[3])) {
                                    $argumentCountError = true;
                                    $expectedArgumentCountString = 'either ' . $argMatch[1] . ' or ' . $argMatch[3];
                                }

                                break;
                        }
                    }
                    if ($argumentCountError) {
                        return $this->raiseFormulaError("Formula Error: Wrong number of arguments for $functionName() function: $argumentCount given, " . $expectedArgumentCountString . ' expected');
                    }
                }
                ++$index;
            } elseif ($opCharacter === ',') { // Is this the separator for function arguments?
                try {
                    $this->branchPruner->argumentSeparator();
                } catch (Exception $e) {
                    return $this->raiseFormulaError($e->getMessage(), $e->getCode(), $e);
                }

                while (($o2 = $stack->pop()) && $o2['value'] !== '(') {        //    Pop off the stack back to the last (
                    $output[] = $o2; // pop the argument expression stuff and push onto the output
                }
                //    If we've a comma when we're expecting an operand, then what we actually have is a null operand;
                //        so push a null onto the stack
                if (($expectingOperand) || (!$expectingOperator)) {
                    $output[] = $stack->getStackItem('Empty Argument', null, 'NULL');
                }
                // make sure there was a function
                $d = $stack->last(2);
                if (!preg_match('/^' . self::CALCULATION_REGEXP_FUNCTION . '$/miu', $d['value'] ?? '', $matches)) {
                    // Can we inject a dummy function at this point so that the braces at least have some context
                    //     because at least the braces are paired up (at this stage in the formula)
                    // MS Excel allows this if the content is cell references; but doesn't allow actual values,
                    //    but at this point, we can't differentiate (so allow both)
                    return $this->raiseFormulaError('Formula Error: Unexpected ,');
                }

                /** @var array $d */
                $d = $stack->pop();
                ++$d['value']; // increment the argument count

                $stack->pushStackItem($d);
                $stack->push('Brace', '('); // put the ( back on, we'll need to pop back to it again

                $expectingOperator = false;
                $expectingOperand = true;
                ++$index;
            } elseif ($opCharacter === '(' && !$expectingOperator) {
                // Branch pruning: we go deeper
                $this->branchPruner->incrementDepth();
                $stack->push('Brace', '(', null);
                ++$index;
            } elseif ($isOperandOrFunction && !$expectingOperatorCopy) {
                // do we now have a function/variable/number?
                $expectingOperator = true;
                $expectingOperand = false;
                $val = $match[1];
                $length = strlen($val);

                if (preg_match('/^' . self::CALCULATION_REGEXP_FUNCTION . '$/miu', $val, $matches)) {
                    $val = (string) preg_replace('/\s/u', '', $val);
                    if (isset(self::$phpSpreadsheetFunctions[strtoupper($matches[1])]) || isset(self::$controlFunctions[strtoupper($matches[1])])) {    // it's a function
                        $valToUpper = strtoupper($val);
                    } else {
                        $valToUpper = 'NAME.ERROR(';
                    }
                    // here $matches[1] will contain values like "IF"
                    // and $val "IF("

                    $this->branchPruner->functionCall($valToUpper);

                    $stack->push('Function', $valToUpper);
                    // tests if the function is closed right after opening
                    $ax = preg_match('/^\s*\)/u', substr($formula, $index + $length));
                    if ($ax) {
                        $stack->push('Operand Count for Function ' . $valToUpper . ')', 0);
                        $expectingOperator = true;
                    } else {
                        $stack->push('Operand Count for Function ' . $valToUpper . ')', 1);
                        $expectingOperator = false;
                    }
                    $stack->push('Brace', '(');
                } elseif (preg_match('/^' . self::CALCULATION_REGEXP_CELLREF . '$/miu', $val, $matches)) {
                    //    Watch for this case-change when modifying to allow cell references in different worksheets...
                    //    Should only be applied to the actual cell column, not the worksheet name
                    //    If the last entry on the stack was a : operator, then we have a cell range reference
                    $testPrevOp = $stack->last(1);
                    if ($testPrevOp !== null && $testPrevOp['value'] === ':') {
                        //    If we have a worksheet reference, then we're playing with a 3D reference
                        if ($matches[2] === '') {
                            //    Otherwise, we 'inherit' the worksheet reference from the start cell reference
                            //    The start of the cell range reference should be the last entry in $output
                            $rangeStartCellRef = $output[count($output) - 1]['value'] ?? '';
                            if ($rangeStartCellRef === ':') {
                                // Do we have chained range operators?
                                $rangeStartCellRef = $output[count($output) - 2]['value'] ?? '';
                            }
                            preg_match('/^' . self::CALCULATION_REGEXP_CELLREF . '$/miu', $rangeStartCellRef, $rangeStartMatches);
                            if (array_key_exists(2, $rangeStartMatches)) {
                                if ($rangeStartMatches[2] > '') {
                                    $val = $rangeStartMatches[2] . '!' . $val;
                                }
                            } else {
                                $val = ExcelError::REF();
                            }
                        } else {
                            $rangeStartCellRef = $output[count($output) - 1]['value'] ?? '';
                            if ($rangeStartCellRef === ':') {
                                // Do we have chained range operators?
                                $rangeStartCellRef = $output[count($output) - 2]['value'] ?? '';
                            }
                            preg_match('/^' . self::CALCULATION_REGEXP_CELLREF . '$/miu', $rangeStartCellRef, $rangeStartMatches);
                            if ($rangeStartMatches[2] !== $matches[2]) {
                                return $this->raiseFormulaError('3D Range references are not yet supported');
                            }
                        }
                    } elseif (!str_contains($val, '!') && $pCellParent !== null) {
                        $worksheet = $pCellParent->getTitle();
                        $val = "'{$worksheet}'!{$val}";
                    }
                    // unescape any apostrophes or double quotes in worksheet name
                    $val = str_replace(["''", '""'], ["'", '"'], $val);
                    $outputItem = $stack->getStackItem('Cell Reference', $val, $val);

                    $output[] = $outputItem;
                } elseif (preg_match('/^' . self::CALCULATION_REGEXP_STRUCTURED_REFERENCE . '$/miu', $val, $matches)) {
                    try {
                        $structuredReference = Operands\StructuredReference::fromParser($formula, $index, $matches);
                    } catch (Exception $e) {
                        return $this->raiseFormulaError($e->getMessage(), $e->getCode(), $e);
                    }

                    $val = $structuredReference->value();
                    $length = strlen($val);
                    $outputItem = $stack->getStackItem(Operands\StructuredReference::NAME, $structuredReference, null);

                    $output[] = $outputItem;
                    $expectingOperator = true;
                } else {
                    // it's a variable, constant, string, number or boolean
                    $localeConstant = false;
                    $stackItemType = 'Value';
                    $stackItemReference = null;

                    //    If the last entry on the stack was a : operator, then we may have a row or column range reference
                    $testPrevOp = $stack->last(1);
                    if ($testPrevOp !== null && $testPrevOp['value'] === ':') {
                        $stackItemType = 'Cell Reference';

                        if (
                            !is_numeric($val)
                            && ((ctype_alpha($val) === false || strlen($val) > 3))
                            && (preg_match('/^' . self::CALCULATION_REGEXP_DEFINEDNAME . '$/mui', $val) !== false)
                            && ($this->spreadsheet === null || $this->spreadsheet->getNamedRange($val) !== null)
                        ) {
                            $namedRange = ($this->spreadsheet === null) ? null : $this->spreadsheet->getNamedRange($val);
                            if ($namedRange !== null) {
                                $stackItemType = 'Defined Name';
                                $address = str_replace('$', '', $namedRange->getValue());
                                $stackItemReference = $val;
                                if (str_contains($address, ':')) {
                                    // We'll need to manipulate the stack for an actual named range rather than a named cell
                                    $fromTo = explode(':', $address);
                                    $to = array_pop($fromTo);
                                    foreach ($fromTo as $from) {
                                        $output[] = $stack->getStackItem($stackItemType, $from, $stackItemReference);
                                        $output[] = $stack->getStackItem('Binary Operator', ':');
                                    }
                                    $address = $to;
                                }
                                $val = $address;
                            }
                        } elseif ($val === ExcelError::REF()) {
                            $stackItemReference = $val;
                        } else {
                            /** @var non-empty-string $startRowColRef */
                            $startRowColRef = $output[count($output) - 1]['value'] ?? '';
                            [$rangeWS1, $startRowColRef] = Worksheet::extractSheetTitle($startRowColRef, true);
                            $rangeSheetRef = $rangeWS1;
                            if ($rangeWS1 !== '') {
                                $rangeWS1 .= '!';
                            }
                            $rangeSheetRef = trim($rangeSheetRef, "'");
                            [$rangeWS2, $val] = Worksheet::extractSheetTitle($val, true);
                            if ($rangeWS2 !== '') {
                                $rangeWS2 .= '!';
                            } else {
                                $rangeWS2 = $rangeWS1;
                            }

                            $refSheet = $pCellParent;
                            if ($pCellParent !== null && $rangeSheetRef !== '' && $rangeSheetRef !== $pCellParent->getTitle()) {
                                $refSheet = $pCellParent->getParentOrThrow()->getSheetByName($rangeSheetRef);
                            }

                            if (ctype_digit($val) && $val <= 1048576) {
                                //    Row range
                                $stackItemType = 'Row Reference';
                                /** @var int $valx */
                                $valx = $val;
                                $endRowColRef = ($refSheet !== null) ? $refSheet->getHighestDataColumn($valx) : AddressRange::MAX_COLUMN; //    Max 16,384 columns for Excel2007
                                $val = "{$rangeWS2}{$endRowColRef}{$val}";
                            } elseif (ctype_alpha($val) && strlen($val ?? '') <= 3) {
                                //    Column range
                                $stackItemType = 'Column Reference';
                                $endRowColRef = ($refSheet !== null) ? $refSheet->getHighestDataRow($val) : AddressRange::MAX_ROW; //    Max 1,048,576 rows for Excel2007
                                $val = "{$rangeWS2}{$val}{$endRowColRef}";
                            }
                            $stackItemReference = $val;
                        }
                    } elseif ($opCharacter === self::FORMULA_STRING_QUOTE) {
                        //    UnEscape any quotes within the string
                        $val = self::wrapResult(str_replace('""', self::FORMULA_STRING_QUOTE, self::unwrapResult($val)));
                    } elseif (isset(self::$excelConstants[trim(strtoupper($val))])) {
                        $stackItemType = 'Constant';
                        $excelConstant = trim(strtoupper($val));
                        $val = self::$excelConstants[$excelConstant];
                        $stackItemReference = $excelConstant;
                    } elseif (($localeConstant = array_search(trim(strtoupper($val)), self::$localeBoolean)) !== false) {
                        $stackItemType = 'Constant';
                        $val = self::$excelConstants[$localeConstant];
                        $stackItemReference = $localeConstant;
                    } elseif (
                        preg_match('/^' . self::CALCULATION_REGEXP_ROW_RANGE . '/miu', substr($formula, $index), $rowRangeReference)
                    ) {
                        $val = $rowRangeReference[1];
                        $length = strlen($rowRangeReference[1]);
                        $stackItemType = 'Row Reference';
                        // unescape any apostrophes or double quotes in worksheet name
                        $val = str_replace(["''", '""'], ["'", '"'], $val);
                        $column = 'A';
                        if (($testPrevOp !== null && $testPrevOp['value'] === ':') && $pCellParent !== null) {
                            $column = $pCellParent->getHighestDataColumn($val);
                        }
                        $val = "{$rowRangeReference[2]}{$column}{$rowRangeReference[7]}";
                        $stackItemReference = $val;
                    } elseif (
                        preg_match('/^' . self::CALCULATION_REGEXP_COLUMN_RANGE . '/miu', substr($formula, $index), $columnRangeReference)
                    ) {
                        $val = $columnRangeReference[1];
                        $length = strlen($val);
                        $stackItemType = 'Column Reference';
                        // unescape any apostrophes or double quotes in worksheet name
                        $val = str_replace(["''", '""'], ["'", '"'], $val);
                        $row = '1';
                        if (($testPrevOp !== null && $testPrevOp['value'] === ':') && $pCellParent !== null) {
                            $row = $pCellParent->getHighestDataRow($val);
                        }
                        $val = "{$val}{$row}";
                        $stackItemReference = $val;
                    } elseif (preg_match('/^' . self::CALCULATION_REGEXP_DEFINEDNAME . '.*/miu', $val, $match)) {
                        $stackItemType = 'Defined Name';
                        $stackItemReference = $val;
                    } elseif (is_numeric($val)) {
                        if ((str_contains((string) $val, '.')) || (stripos((string) $val, 'e') !== false) || ($val > PHP_INT_MAX) || ($val < -PHP_INT_MAX)) {
                            $val = (float) $val;
                        } else {
                            $val = (int) $val;
                        }
                    }

                    $details = $stack->getStackItem($stackItemType, $val, $stackItemReference);
                    if ($localeConstant) {
                        $details['localeValue'] = $localeConstant;
                    }
                    $output[] = $details;
                }
                $index += $length;
            } elseif ($opCharacter === '$') { // absolute row or column range
                ++$index;
            } elseif ($opCharacter === ')') { // miscellaneous error checking
                if ($expectingOperand) {
                    $output[] = $stack->getStackItem('Empty Argument', null, 'NULL');
                    $expectingOperand = false;
                    $expectingOperator = true;
                } else {
                    return $this->raiseFormulaError("Formula Error: Unexpected ')'");
                }
            } elseif (isset(self::CALCULATION_OPERATORS[$opCharacter]) && !$expectingOperator) {
                return $this->raiseFormulaError("Formula Error: Unexpected operator '$opCharacter'");
            } else {    // I don't even want to know what you did to get here
                return $this->raiseFormulaError('Formula Error: An unexpected error occurred');
            }
            //    Test for end of formula string
            if ($index == strlen($formula)) {
                //    Did we end with an operator?.
                //    Only valid for the % unary operator
                if ((isset(self::CALCULATION_OPERATORS[$opCharacter])) && ($opCharacter != '%')) {
                    return $this->raiseFormulaError("Formula Error: Operator '$opCharacter' has no operands");
                }

                break;
            }
            //    Ignore white space
            while (($formula[$index] === "\n") || ($formula[$index] === "\r")) {
                ++$index;
            }

            if ($formula[$index] === ' ') {
                while ($formula[$index] === ' ') {
                    ++$index;
                }

                //    If we're expecting an operator, but only have a space between the previous and next operands (and both are
                //        Cell References, Defined Names or Structured References) then we have an INTERSECTION operator
                $countOutputMinus1 = count($output) - 1;
                if (
                    ($expectingOperator)
                    && array_key_exists($countOutputMinus1, $output)
                    && is_array($output[$countOutputMinus1])
                    && array_key_exists('type', $output[$countOutputMinus1])
                    && (
                        (preg_match('/^' . self::CALCULATION_REGEXP_CELLREF . '.*/miu', substr($formula, $index), $match))
                            && ($output[$countOutputMinus1]['type'] === 'Cell Reference')
                        || (preg_match('/^' . self::CALCULATION_REGEXP_DEFINEDNAME . '.*/miu', substr($formula, $index), $match))
                            && ($output[$countOutputMinus1]['type'] === 'Defined Name' || $output[$countOutputMinus1]['type'] === 'Value')
                        || (preg_match('/^' . self::CALCULATION_REGEXP_STRUCTURED_REFERENCE . '.*/miu', substr($formula, $index), $match))
                            && ($output[$countOutputMinus1]['type'] === Operands\StructuredReference::NAME || $output[$countOutputMinus1]['type'] === 'Value')
                    )
                ) {
                    while (
                        $stack->count() > 0
                        && ($o2 = $stack->last())
                        && isset(self::CALCULATION_OPERATORS[$o2['value']])
                        && @(self::$operatorAssociativity[$opCharacter] ? self::$operatorPrecedence[$opCharacter] < self::$operatorPrecedence[$o2['value']] : self::$operatorPrecedence[$opCharacter] <= self::$operatorPrecedence[$o2['value']])
                    ) {
                        $output[] = $stack->pop(); //    Swap operands and higher precedence operators from the stack to the output
                    }
                    $stack->push('Binary Operator', '∩'); //    Put an Intersect Operator on the stack
                    $expectingOperator = false;
                }
            }
        }

        while (($op = $stack->pop()) !== null) {
            // pop everything off the stack and push onto output
            if ((is_array($op) && $op['value'] == '(')) {
                return $this->raiseFormulaError("Formula Error: Expecting ')'"); // if there are any opening braces on the stack, then braces were unbalanced
            }
            $output[] = $op;
        }

        return $output;
    }

    private static function dataTestReference(array &$operandData): mixed
    {
        $operand = $operandData['value'];
        if (($operandData['reference'] === null) && (is_array($operand))) {
            $rKeys = array_keys($operand);
            $rowKey = array_shift($rKeys);
            if (is_array($operand[$rowKey]) === false) {
                $operandData['value'] = $operand[$rowKey];

                return $operand[$rowKey];
            }

            $cKeys = array_keys(array_keys($operand[$rowKey]));
            $colKey = array_shift($cKeys);
            if (ctype_upper("$colKey")) {
                $operandData['reference'] = $colKey . $rowKey;
            }
        }

        return $operand;
    }

    /**
     * @return array<int, mixed>|false
     */
    private function processTokenStack(mixed $tokens, ?string $cellID = null, ?Cell $cell = null)
    {
        if ($tokens === false) {
            return false;
        }

        //    If we're using cell caching, then $pCell may well be flushed back to the cache (which detaches the parent cell collection),
        //        so we store the parent cell collection so that we can re-attach it when necessary
        $pCellWorksheet = ($cell !== null) ? $cell->getWorksheet() : null;
        $originalCoordinate = $cell?->getCoordinate();
        $pCellParent = ($cell !== null) ? $cell->getParent() : null;
        $stack = new Stack($this->branchPruner);

        // Stores branches that have been pruned
        $fakedForBranchPruning = [];
        // help us to know when pruning ['branchTestId' => true/false]
        $branchStore = [];
        //    Loop through each token in turn
        foreach ($tokens as $tokenIdx => $tokenData) {
            $this->processingAnchorArray = false;
            if ($tokenData['type'] === 'Cell Reference' && isset($tokens[$tokenIdx + 1]) && $tokens[$tokenIdx + 1]['type'] === 'Operand Count for Function ANCHORARRAY()') {
                $this->processingAnchorArray = true;
            }
            $token = $tokenData['value'];
            // Branch pruning: skip useless resolutions
            $storeKey = $tokenData['storeKey'] ?? null;
            if ($this->branchPruningEnabled && isset($tokenData['onlyIf'])) {
                $onlyIfStoreKey = $tokenData['onlyIf'];
                $storeValue = $branchStore[$onlyIfStoreKey] ?? null;
                $storeValueAsBool = ($storeValue === null)
                    ? true : (bool) Functions::flattenSingleValue($storeValue);
                if (is_array($storeValue)) {
                    $wrappedItem = end($storeValue);
                    $storeValue = is_array($wrappedItem) ? end($wrappedItem) : $wrappedItem;
                }

                if (
                    (isset($storeValue) || $tokenData['reference'] === 'NULL')
                    && (!$storeValueAsBool || Information\ErrorValue::isError($storeValue) || ($storeValue === 'Pruned branch'))
                ) {
                    // If branching value is not true, we don't need to compute
                    if (!isset($fakedForBranchPruning['onlyIf-' . $onlyIfStoreKey])) {
                        $stack->push('Value', 'Pruned branch (only if ' . $onlyIfStoreKey . ') ' . $token);
                        $fakedForBranchPruning['onlyIf-' . $onlyIfStoreKey] = true;
                    }

                    if (isset($storeKey)) {
                        // We are processing an if condition
                        // We cascade the pruning to the depending branches
                        $branchStore[$storeKey] = 'Pruned branch';
                        $fakedForBranchPruning['onlyIfNot-' . $storeKey] = true;
                        $fakedForBranchPruning['onlyIf-' . $storeKey] = true;
                    }

                    continue;
                }
            }

            if ($this->branchPruningEnabled && isset($tokenData['onlyIfNot'])) {
                $onlyIfNotStoreKey = $tokenData['onlyIfNot'];
                $storeValue = $branchStore[$onlyIfNotStoreKey] ?? null;
                $storeValueAsBool = ($storeValue === null)
                    ? true : (bool) Functions::flattenSingleValue($storeValue);
                if (is_array($storeValue)) {
                    $wrappedItem = end($storeValue);
                    $storeValue = is_array($wrappedItem) ? end($wrappedItem) : $wrappedItem;
                }

                if (
                    (isset($storeValue) || $tokenData['reference'] === 'NULL')
                    && ($storeValueAsBool || Information\ErrorValue::isError($storeValue) || ($storeValue === 'Pruned branch'))
                ) {
                    // If branching value is true, we don't need to compute
                    if (!isset($fakedForBranchPruning['onlyIfNot-' . $onlyIfNotStoreKey])) {
                        $stack->push('Value', 'Pruned branch (only if not ' . $onlyIfNotStoreKey . ') ' . $token);
                        $fakedForBranchPruning['onlyIfNot-' . $onlyIfNotStoreKey] = true;
                    }

                    if (isset($storeKey)) {
                        // We are processing an if condition
                        // We cascade the pruning to the depending branches
                        $branchStore[$storeKey] = 'Pruned branch';
                        $fakedForBranchPruning['onlyIfNot-' . $storeKey] = true;
                        $fakedForBranchPruning['onlyIf-' . $storeKey] = true;
                    }

                    continue;
                }
            }

            if ($token instanceof Operands\StructuredReference) {
                if ($cell === null) {
                    return $this->raiseFormulaError('Structured References must exist in a Cell context');
                }

                try {
                    $cellRange = $token->parse($cell);
                    if (str_contains($cellRange, ':')) {
                        $this->debugLog->writeDebugLog('Evaluating Structured Reference %s as Cell Range %s', $token->value(), $cellRange);
                        $rangeValue = self::getInstance($cell->getWorksheet()->getParent())->_calculateFormulaValue("={$cellRange}", $cellRange, $cell);
                        $stack->push('Value', $rangeValue);
                        $this->debugLog->writeDebugLog('Evaluated Structured Reference %s as value %s', $token->value(), $this->showValue($rangeValue));
                    } else {
                        $this->debugLog->writeDebugLog('Evaluating Structured Reference %s as Cell %s', $token->value(), $cellRange);
                        $cellValue = $cell->getWorksheet()->getCell($cellRange)->getCalculatedValue(false);
                        $stack->push('Cell Reference', $cellValue, $cellRange);
                        $this->debugLog->writeDebugLog('Evaluated Structured Reference %s as value %s', $token->value(), $this->showValue($cellValue));
                    }
                } catch (Exception $e) {
                    if ($e->getCode() === Exception::CALCULATION_ENGINE_PUSH_TO_STACK) {
                        $stack->push('Error', ExcelError::REF(), null);
                        $this->debugLog->writeDebugLog('Evaluated Structured Reference %s as error value %s', $token->value(), ExcelError::REF());
                    } else {
                        return $this->raiseFormulaError($e->getMessage(), $e->getCode(), $e);
                    }
                }
            } elseif (!is_numeric($token) && !is_object($token) && isset(self::BINARY_OPERATORS[$token])) {
                // if the token is a binary operator, pop the top two values off the stack, do the operation, and push the result back on the stack
                //    We must have two operands, error if we don't
                $operand2Data = $stack->pop();
                if ($operand2Data === null) {
                    return $this->raiseFormulaError('Internal error - Operand value missing from stack');
                }
                $operand1Data = $stack->pop();
                if ($operand1Data === null) {
                    return $this->raiseFormulaError('Internal error - Operand value missing from stack');
                }

                $operand1 = self::dataTestReference($operand1Data);
                $operand2 = self::dataTestReference($operand2Data);

                //    Log what we're doing
                if ($token == ':') {
                    $this->debugLog->writeDebugLog('Evaluating Range %s %s %s', $this->showValue($operand1Data['reference']), $token, $this->showValue($operand2Data['reference']));
                } else {
                    $this->debugLog->writeDebugLog('Evaluating %s %s %s', $this->showValue($operand1), $token, $this->showValue($operand2));
                }

                //    Process the operation in the appropriate manner
                switch ($token) {
                    // Comparison (Boolean) Operators
                    case '>': // Greater than
                    case '<': // Less than
                    case '>=': // Greater than or Equal to
                    case '<=': // Less than or Equal to
                    case '=': // Equality
                    case '<>': // Inequality
                        $result = $this->executeBinaryComparisonOperation($operand1, $operand2, (string) $token, $stack);
                        if (isset($storeKey)) {
                            $branchStore[$storeKey] = $result;
                        }

                        break;
                    // Binary Operators
                    case ':': // Range
                        if ($operand1Data['type'] === 'Defined Name') {
                            if (preg_match('/$' . self::CALCULATION_REGEXP_DEFINEDNAME . '^/mui', $operand1Data['reference']) !== false && $this->spreadsheet !== null) {
                                $definedName = $this->spreadsheet->getNamedRange($operand1Data['reference']);
                                if ($definedName !== null) {
                                    $operand1Data['reference'] = $operand1Data['value'] = str_replace('$', '', $definedName->getValue());
                                }
                            }
                        }
                        if (str_contains($operand1Data['reference'] ?? '', '!')) {
                            [$sheet1, $operand1Data['reference']] = Worksheet::extractSheetTitle($operand1Data['reference'], true);
                        } else {
                            $sheet1 = ($pCellWorksheet !== null) ? $pCellWorksheet->getTitle() : '';
                        }
                        $sheet1 ??= '';

                        [$sheet2, $operand2Data['reference']] = Worksheet::extractSheetTitle($operand2Data['reference'], true);
                        if (empty($sheet2)) {
                            $sheet2 = $sheet1;
                        }

                        if (trim($sheet1, "'") === trim($sheet2, "'")) {
                            if ($operand1Data['reference'] === null && $cell !== null) {
                                if (is_array($operand1Data['value'])) {
                                    $operand1Data['reference'] = $cell->getCoordinate();
                                } elseif ((trim($operand1Data['value']) != '') && (is_numeric($operand1Data['value']))) {
                                    $operand1Data['reference'] = $cell->getColumn() . $operand1Data['value'];
                                } elseif (trim($operand1Data['value']) == '') {
                                    $operand1Data['reference'] = $cell->getCoordinate();
                                } else {
                                    $operand1Data['reference'] = $operand1Data['value'] . $cell->getRow();
                                }
                            }
                            if ($operand2Data['reference'] === null && $cell !== null) {
                                if (is_array($operand2Data['value'])) {
                                    $operand2Data['reference'] = $cell->getCoordinate();
                                } elseif ((trim($operand2Data['value']) != '') && (is_numeric($operand2Data['value']))) {
                                    $operand2Data['reference'] = $cell->getColumn() . $operand2Data['value'];
                                } elseif (trim($operand2Data['value']) == '') {
                                    $operand2Data['reference'] = $cell->getCoordinate();
                                } else {
                                    $operand2Data['reference'] = $operand2Data['value'] . $cell->getRow();
                                }
                            }

                            $oData = array_merge(explode(':', $operand1Data['reference'] ?? ''), explode(':', $operand2Data['reference'] ?? ''));
                            $oCol = $oRow = [];
                            $breakNeeded = false;
                            foreach ($oData as $oDatum) {
                                try {
                                    $oCR = Coordinate::coordinateFromString($oDatum);
                                    $oCol[] = Coordinate::columnIndexFromString($oCR[0]) - 1;
                                    $oRow[] = $oCR[1];
                                } catch (\Exception) {
                                    $stack->push('Error', ExcelError::REF(), null);
                                    $breakNeeded = true;

                                    break;
                                }
                            }
                            if ($breakNeeded) {
                                break;
                            }
                            $cellRef = Coordinate::stringFromColumnIndex(min($oCol) + 1) . min($oRow) . ':' . Coordinate::stringFromColumnIndex(max($oCol) + 1) . max($oRow);
                            if ($pCellParent !== null && $this->spreadsheet !== null) {
                                $cellValue = $this->extractCellRange($cellRef, $this->spreadsheet->getSheetByName($sheet1), false);
                            } else {
                                return $this->raiseFormulaError('Unable to access Cell Reference');
                            }

                            $this->debugLog->writeDebugLog('Evaluation Result is %s', $this->showTypeDetails($cellValue));
                            $stack->push('Cell Reference', $cellValue, $cellRef);
                        } else {
                            $this->debugLog->writeDebugLog('Evaluation Result is a #REF! Error');
                            $stack->push('Error', ExcelError::REF(), null);
                        }

                        break;
                    case '+':            //    Addition
                    case '-':            //    Subtraction
                    case '*':            //    Multiplication
                    case '/':            //    Division
                    case '^':            //    Exponential
                        $result = $this->executeNumericBinaryOperation($operand1, $operand2, $token, $stack);
                        if (isset($storeKey)) {
                            $branchStore[$storeKey] = $result;
                        }

                        break;
                    case '&':            //    Concatenation
                        //    If either of the operands is a matrix, we need to treat them both as matrices
                        //        (converting the other operand to a matrix if need be); then perform the required
                        //        matrix operation
                        $operand1 = self::boolToString($operand1);
                        $operand2 = self::boolToString($operand2);
                        if (is_array($operand1) || is_array($operand2)) {
                            if (is_string($operand1)) {
                                $operand1 = self::unwrapResult($operand1);
                            }
                            if (is_string($operand2)) {
                                $operand2 = self::unwrapResult($operand2);
                            }
                            //    Ensure that both operands are arrays/matrices
                            [$rows, $columns] = self::checkMatrixOperands($operand1, $operand2, 2);

                            for ($row = 0; $row < $rows; ++$row) {
                                for ($column = 0; $column < $columns; ++$column) {
                                    $op1x = self::boolToString($operand1[$row][$column]);
                                    $op2x = self::boolToString($operand2[$row][$column]);
                                    if (Information\ErrorValue::isError($op1x)) {
                                        // no need to do anything
                                    } elseif (Information\ErrorValue::isError($op2x)) {
                                        $operand1[$row][$column] = $op2x;
                                    } else {
                                        $operand1[$row][$column]
                                            = Shared\StringHelper::substring(
                                                $op1x . $op2x,
                                                0,
                                                DataType::MAX_STRING_LENGTH
                                            );
                                    }
                                }
                            }
                            $result = $operand1;
                        } else {
                            // In theory, we should truncate here.
                            // But I can't figure out a formula
                            // using the concatenation operator
                            // with literals that fits in 32K,
                            // so I don't think we can overflow here.
                            if (Information\ErrorValue::isError($operand1)) {
                                $result = $operand1;
                            } elseif (Information\ErrorValue::isError($operand2)) {
                                $result = $operand2;
                            } else {
                                $result = self::FORMULA_STRING_QUOTE . str_replace('""', self::FORMULA_STRING_QUOTE, self::unwrapResult($operand1) . self::unwrapResult($operand2)) . self::FORMULA_STRING_QUOTE;
                            }
                        }
                        $this->debugLog->writeDebugLog('Evaluation Result is %s', $this->showTypeDetails($result));
                        $stack->push('Value', $result);

                        if (isset($storeKey)) {
                            $branchStore[$storeKey] = $result;
                        }

                        break;
                    case '∩':            //    Intersect
                        $rowIntersect = array_intersect_key($operand1, $operand2);
                        $cellIntersect = $oCol = $oRow = [];
                        foreach (array_keys($rowIntersect) as $row) {
                            $oRow[] = $row;
                            foreach ($rowIntersect[$row] as $col => $data) {
                                $oCol[] = Coordinate::columnIndexFromString($col) - 1;
                                $cellIntersect[$row] = array_intersect_key($operand1[$row], $operand2[$row]);
                            }
                        }
                        if (count(Functions::flattenArray($cellIntersect)) === 0) {
                            $this->debugLog->writeDebugLog('Evaluation Result is %s', $this->showTypeDetails($cellIntersect));
                            $stack->push('Error', ExcelError::null(), null);
                        } else {
                            $cellRef = Coordinate::stringFromColumnIndex(min($oCol) + 1) . min($oRow) . ':'
                                . Coordinate::stringFromColumnIndex(max($oCol) + 1) . max($oRow);
                            $this->debugLog->writeDebugLog('Evaluation Result is %s', $this->showTypeDetails($cellIntersect));
                            $stack->push('Value', $cellIntersect, $cellRef);
                        }

                        break;
                }
            } elseif (($token === '~') || ($token === '%')) {
                // if the token is a unary operator, pop one value off the stack, do the operation, and push it back on
                if (($arg = $stack->pop()) === null) {
                    return $this->raiseFormulaError('Internal error - Operand value missing from stack');
                }
                $arg = $arg['value'];
                if ($token === '~') {
                    $this->debugLog->writeDebugLog('Evaluating Negation of %s', $this->showValue($arg));
                    $multiplier = -1;
                } else {
                    $this->debugLog->writeDebugLog('Evaluating Percentile of %s', $this->showValue($arg));
                    $multiplier = 0.01;
                }
                if (is_array($arg)) {
                    $operand2 = $multiplier;
                    $result = $arg;
                    [$rows, $columns] = self::checkMatrixOperands($result, $operand2, 0);
                    for ($row = 0; $row < $rows; ++$row) {
                        for ($column = 0; $column < $columns; ++$column) {
                            if (self::isNumericOrBool($result[$row][$column])) {
                                $result[$row][$column] *= $multiplier;
                            } else {
                                $result[$row][$column] = self::makeError($result[$row][$column]);
                            }
                        }
                    }

                    $this->debugLog->writeDebugLog('Evaluation Result is %s', $this->showTypeDetails($result));
                    $stack->push('Value', $result);
                    if (isset($storeKey)) {
                        $branchStore[$storeKey] = $result;
                    }
                } else {
                    $this->executeNumericBinaryOperation($multiplier, $arg, '*', $stack);
                }
            } elseif (preg_match('/^' . self::CALCULATION_REGEXP_CELLREF . '$/i', $token ?? '', $matches)) {
                $cellRef = null;

                if (isset($matches[8])) {
                    if ($cell === null) {
                        // We can't access the range, so return a REF error
                        $cellValue = ExcelError::REF();
                    } else {
                        $cellRef = $matches[6] . $matches[7] . ':' . $matches[9] . $matches[10];
                        if ($matches[2] > '') {
                            $matches[2] = trim($matches[2], "\"'");
                            if ((str_contains($matches[2], '[')) || (str_contains($matches[2], ']'))) {
                                //    It's a Reference to an external spreadsheet (not currently supported)
                                return $this->raiseFormulaError('Unable to access External Workbook');
                            }
                            $matches[2] = trim($matches[2], "\"'");
                            $this->debugLog->writeDebugLog('Evaluating Cell Range %s in worksheet %s', $cellRef, $matches[2]);
                            if ($pCellParent !== null && $this->spreadsheet !== null) {
                                $cellValue = $this->extractCellRange($cellRef, $this->spreadsheet->getSheetByName($matches[2]), false);
                            } else {
                                return $this->raiseFormulaError('Unable to access Cell Reference');
                            }
                            $this->debugLog->writeDebugLog('Evaluation Result for cells %s in worksheet %s is %s', $cellRef, $matches[2], $this->showTypeDetails($cellValue));
                        } else {
                            $this->debugLog->writeDebugLog('Evaluating Cell Range %s in current worksheet', $cellRef);
                            if ($pCellParent !== null) {
                                $cellValue = $this->extractCellRange($cellRef, $pCellWorksheet, false);
                            } else {
                                return $this->raiseFormulaError('Unable to access Cell Reference');
                            }
                            $this->debugLog->writeDebugLog('Evaluation Result for cells %s is %s', $cellRef, $this->showTypeDetails($cellValue));
                        }
                    }
                } else {
                    if ($cell === null) {
                        // We can't access the cell, so return a REF error
                        $cellValue = ExcelError::REF();
                    } else {
                        $cellRef = $matches[6] . $matches[7];
                        if ($matches[2] > '') {
                            $matches[2] = trim($matches[2], "\"'");
                            if ((str_contains($matches[2], '[')) || (str_contains($matches[2], ']'))) {
                                //    It's a Reference to an external spreadsheet (not currently supported)
                                return $this->raiseFormulaError('Unable to access External Workbook');
                            }
                            $this->debugLog->writeDebugLog('Evaluating Cell %s in worksheet %s', $cellRef, $matches[2]);
                            if ($pCellParent !== null && $this->spreadsheet !== null) {
                                $cellSheet = $this->spreadsheet->getSheetByName($matches[2]);
                                if ($cellSheet && $cellSheet->cellExists($cellRef)) {
                                    $cellValue = $this->extractCellRange($cellRef, $this->spreadsheet->getSheetByName($matches[2]), false);
                                    $cell->attach($pCellParent);
                                } else {
                                    $cellRef = ($cellSheet !== null) ? "'{$matches[2]}'!{$cellRef}" : $cellRef;
                                    $cellValue = ($cellSheet !== null) ? null : ExcelError::REF();
                                }
                            } else {
                                return $this->raiseFormulaError('Unable to access Cell Reference');
                            }
                            $this->debugLog->writeDebugLog('Evaluation Result for cell %s in worksheet %s is %s', $cellRef, $matches[2], $this->showTypeDetails($cellValue));
                        } else {
                            $this->debugLog->writeDebugLog('Evaluating Cell %s in current worksheet', $cellRef);
                            if ($pCellParent !== null && $pCellParent->has($cellRef)) {
                                $cellValue = $this->extractCellRange($cellRef, $pCellWorksheet, false);
                                $cell->attach($pCellParent);
                            } else {
                                $cellValue = null;
                            }
                            $this->debugLog->writeDebugLog('Evaluation Result for cell %s is %s', $cellRef, $this->showTypeDetails($cellValue));
                        }
                    }
                }

                if ($this->getInstanceArrayReturnType() === self::RETURN_ARRAY_AS_ARRAY && !$this->processingAnchorArray && is_array($cellValue)) {
                    while (is_array($cellValue)) {
                        $cellValue = array_shift($cellValue);
                    }
                    $this->debugLog->writeDebugLog('Scalar Result for cell %s is %s', $cellRef, $this->showTypeDetails($cellValue));
                }
                $this->processingAnchorArray = false;
                $stack->push('Cell Value', $cellValue, $cellRef);
                if (isset($storeKey)) {
                    $branchStore[$storeKey] = $cellValue;
                }
            } elseif (preg_match('/^' . self::CALCULATION_REGEXP_FUNCTION . '$/miu', $token ?? '', $matches)) {
                // if the token is a function, pop arguments off the stack, hand them to the function, and push the result back on
                if ($cell !== null && $pCellParent !== null) {
                    $cell->attach($pCellParent);
                }

                $functionName = $matches[1];
                $argCount = $stack->pop();
                $argCount = $argCount['value'];
                if ($functionName !== 'MKMATRIX') {
                    $this->debugLog->writeDebugLog('Evaluating Function %s() with %s argument%s', self::localeFunc($functionName), (($argCount == 0) ? 'no' : $argCount), (($argCount == 1) ? '' : 's'));
                }
                if ((isset(self::$phpSpreadsheetFunctions[$functionName])) || (isset(self::$controlFunctions[$functionName]))) {    // function
                    $passByReference = false;
                    $passCellReference = false;
                    $functionCall = null;
                    if (isset(self::$phpSpreadsheetFunctions[$functionName])) {
                        $functionCall = self::$phpSpreadsheetFunctions[$functionName]['functionCall'];
                        $passByReference = isset(self::$phpSpreadsheetFunctions[$functionName]['passByReference']);
                        $passCellReference = isset(self::$phpSpreadsheetFunctions[$functionName]['passCellReference']);
                    } elseif (isset(self::$controlFunctions[$functionName])) {
                        $functionCall = self::$controlFunctions[$functionName]['functionCall'];
                        $passByReference = isset(self::$controlFunctions[$functionName]['passByReference']);
                        $passCellReference = isset(self::$controlFunctions[$functionName]['passCellReference']);
                    }

                    // get the arguments for this function
                    $args = $argArrayVals = [];
                    $emptyArguments = [];
                    for ($i = 0; $i < $argCount; ++$i) {
                        $arg = $stack->pop();
                        $a = $argCount - $i - 1;
                        if (
                            ($passByReference)
                            && (isset(self::$phpSpreadsheetFunctions[$functionName]['passByReference'][$a]))
                            && (self::$phpSpreadsheetFunctions[$functionName]['passByReference'][$a])
                        ) {
                            if ($arg['reference'] === null) {
                                $nextArg = $cellID;
                                if ($functionName === 'ISREF' && is_array($arg) && ($arg['type'] ?? '') === 'Value') {
                                    if (array_key_exists('value', $arg)) {
                                        $argValue = $arg['value'];
                                        if (is_scalar($argValue)) {
                                            $nextArg = $argValue;
                                        } elseif (empty($argValue)) {
                                            $nextArg = '';
                                        }
                                    }
                                }
                                $args[] = $nextArg;
                                if ($functionName !== 'MKMATRIX') {
                                    $argArrayVals[] = $this->showValue($cellID);
                                }
                            } else {
                                $args[] = $arg['reference'];
                                if ($functionName !== 'MKMATRIX') {
                                    $argArrayVals[] = $this->showValue($arg['reference']);
                                }
                            }
                        } else {
                            if ($arg['type'] === 'Empty Argument' && in_array($functionName, ['MIN', 'MINA', 'MAX', 'MAXA', 'IF'], true)) {
                                $emptyArguments[] = false;
                                $args[] = $arg['value'] = 0;
                                $this->debugLog->writeDebugLog('Empty Argument reevaluated as 0');
                            } else {
                                $emptyArguments[] = $arg['type'] === 'Empty Argument';
                                $args[] = self::unwrapResult($arg['value']);
                            }
                            if ($functionName !== 'MKMATRIX') {
                                $argArrayVals[] = $this->showValue($arg['value']);
                            }
                        }
                    }

                    //    Reverse the order of the arguments
                    krsort($args);
                    krsort($emptyArguments);

                    if ($argCount > 0 && is_array($functionCall)) {
                        $args = $this->addDefaultArgumentValues($functionCall, $args, $emptyArguments);
                    }

                    if (($passByReference) && ($argCount == 0)) {
                        $args[] = $cellID;
                        $argArrayVals[] = $this->showValue($cellID);
                    }

                    if ($functionName !== 'MKMATRIX') {
                        if ($this->debugLog->getWriteDebugLog()) {
                            krsort($argArrayVals);
                            $this->debugLog->writeDebugLog('Evaluating %s ( %s )', self::localeFunc($functionName), implode(self::$localeArgumentSeparator . ' ', Functions::flattenArray($argArrayVals)));
                        }
                    }

                    //    Process the argument with the appropriate function call
                    if ($pCellWorksheet !== null && $originalCoordinate !== null) {
                        $pCellWorksheet->getCell($originalCoordinate);
                    }
                    $args = $this->addCellReference($args, $passCellReference, $functionCall, $cell);

                    if (!is_array($functionCall)) {
                        foreach ($args as &$arg) {
                            $arg = Functions::flattenSingleValue($arg);
                        }
                        unset($arg);
                    }

                    $result = call_user_func_array($functionCall, $args);

                    if ($functionName !== 'MKMATRIX') {
                        $this->debugLog->writeDebugLog('Evaluation Result for %s() function call is %s', self::localeFunc($functionName), $this->showTypeDetails($result));
                    }
                    $stack->push('Value', self::wrapResult($result));
                    if (isset($storeKey)) {
                        $branchStore[$storeKey] = $result;
                    }
                }
            } else {
                // if the token is a number, boolean, string or an Excel error, push it onto the stack
                if (isset(self::$excelConstants[strtoupper($token ?? '')])) {
                    $excelConstant = strtoupper($token);
                    $stack->push('Constant Value', self::$excelConstants[$excelConstant]);
                    if (isset($storeKey)) {
                        $branchStore[$storeKey] = self::$excelConstants[$excelConstant];
                    }
                    $this->debugLog->writeDebugLog('Evaluating Constant %s as %s', $excelConstant, $this->showTypeDetails(self::$excelConstants[$excelConstant]));
                } elseif ((is_numeric($token)) || ($token === null) || (is_bool($token)) || ($token == '') || ($token[0] == self::FORMULA_STRING_QUOTE) || ($token[0] == '#')) {
                    $stack->push($tokenData['type'], $token, $tokenData['reference']);
                    if (isset($storeKey)) {
                        $branchStore[$storeKey] = $token;
                    }
                } elseif (preg_match('/^' . self::CALCULATION_REGEXP_DEFINEDNAME . '$/miu', $token, $matches)) {
                    // if the token is a named range or formula, evaluate it and push the result onto the stack
                    $definedName = $matches[6];
                    if ($cell === null || $pCellWorksheet === null) {
                        return $this->raiseFormulaError("undefined name '$token'");
                    }
                    $specifiedWorksheet = trim($matches[2], "'");

                    $this->debugLog->writeDebugLog('Evaluating Defined Name %s', $definedName);
                    $namedRange = DefinedName::resolveName($definedName, $pCellWorksheet, $specifiedWorksheet);
                    // If not Defined Name, try as Table.
                    if ($namedRange === null && $this->spreadsheet !== null) {
                        $table = $this->spreadsheet->getTableByName($definedName);
                        if ($table !== null) {
                            $tableRange = Coordinate::getRangeBoundaries($table->getRange());
                            if ($table->getShowHeaderRow()) {
                                ++$tableRange[0][1];
                            }
                            if ($table->getShowTotalsRow()) {
                                --$tableRange[1][1];
                            }
                            $tableRangeString
                                = '$' . $tableRange[0][0]
                                . '$' . $tableRange[0][1]
                                . ':'
                                . '$' . $tableRange[1][0]
                                . '$' . $tableRange[1][1];
                            $namedRange = new NamedRange($definedName, $table->getWorksheet(), $tableRangeString);
                        }
                    }
                    if ($namedRange === null) {
                        return $this->raiseFormulaError("undefined name '$definedName'");
                    }

                    $result = $this->evaluateDefinedName($cell, $namedRange, $pCellWorksheet, $stack, $specifiedWorksheet !== '');
                    if (isset($storeKey)) {
                        $branchStore[$storeKey] = $result;
                    }
                } else {
                    return $this->raiseFormulaError("undefined name '$token'");
                }
            }
        }
        // when we're out of tokens, the stack should have a single element, the final result
        if ($stack->count() != 1) {
            return $this->raiseFormulaError('internal error');
        }
        $output = $stack->pop();
        $output = $output['value'];

        return $output;
    }

    private function validateBinaryOperand(mixed &$operand, mixed &$stack): bool
    {
        if (is_array($operand)) {
            if ((count($operand, COUNT_RECURSIVE) - count($operand)) == 1) {
                do {
                    $operand = array_pop($operand);
                } while (is_array($operand));
            }
        }
        //    Numbers, matrices and booleans can pass straight through, as they're already valid
        if (is_string($operand)) {
            //    We only need special validations for the operand if it is a string
            //    Start by stripping off the quotation marks we use to identify true excel string values internally
            if ($operand > '' && $operand[0] == self::FORMULA_STRING_QUOTE) {
                $operand = self::unwrapResult($operand);
            }
            //    If the string is a numeric value, we treat it as a numeric, so no further testing
            if (!is_numeric($operand)) {
                //    If not a numeric, test to see if the value is an Excel error, and so can't be used in normal binary operations
                if ($operand > '' && $operand[0] == '#') {
                    $stack->push('Value', $operand);
                    $this->debugLog->writeDebugLog('Evaluation Result is %s', $this->showTypeDetails($operand));

                    return false;
                } elseif (Engine\FormattedNumber::convertToNumberIfFormatted($operand) === false) {
                    //    If not a numeric, a fraction or a percentage, then it's a text string, and so can't be used in mathematical binary operations
                    $stack->push('Error', '#VALUE!');
                    $this->debugLog->writeDebugLog('Evaluation Result is a %s', $this->showTypeDetails('#VALUE!'));

                    return false;
                }
            }
        }

        //    return a true if the value of the operand is one that we can use in normal binary mathematical operations
        return true;
    }

    private function executeArrayComparison(mixed $operand1, mixed $operand2, string $operation, Stack &$stack, bool $recursingArrays): array
    {
        $result = [];
        if (!is_array($operand2)) {
            // Operand 1 is an array, Operand 2 is a scalar
            foreach ($operand1 as $x => $operandData) {
                $this->debugLog->writeDebugLog('Evaluating Comparison %s %s %s', $this->showValue($operandData), $operation, $this->showValue($operand2));
                $this->executeBinaryComparisonOperation($operandData, $operand2, $operation, $stack);
                $r = $stack->pop();
                $result[$x] = $r['value'];
            }
        } elseif (!is_array($operand1)) {
            // Operand 1 is a scalar, Operand 2 is an array
            foreach ($operand2 as $x => $operandData) {
                $this->debugLog->writeDebugLog('Evaluating Comparison %s %s %s', $this->showValue($operand1), $operation, $this->showValue($operandData));
                $this->executeBinaryComparisonOperation($operand1, $operandData, $operation, $stack);
                $r = $stack->pop();
                $result[$x] = $r['value'];
            }
        } else {
            // Operand 1 and Operand 2 are both arrays
            if (!$recursingArrays) {
                self::checkMatrixOperands($operand1, $operand2, 2);
            }
            foreach ($operand1 as $x => $operandData) {
                $this->debugLog->writeDebugLog('Evaluating Comparison %s %s %s', $this->showValue($operandData), $operation, $this->showValue($operand2[$x]));
                $this->executeBinaryComparisonOperation($operandData, $operand2[$x], $operation, $stack, true);
                $r = $stack->pop();
                $result[$x] = $r['value'];
            }
        }
        //    Log the result details
        $this->debugLog->writeDebugLog('Comparison Evaluation Result is %s', $this->showTypeDetails($result));
        //    And push the result onto the stack
        $stack->push('Array', $result);

        return $result;
    }

    private function executeBinaryComparisonOperation(mixed $operand1, mixed $operand2, string $operation, Stack &$stack, bool $recursingArrays = false): array|bool
    {
        //    If we're dealing with matrix operations, we want a matrix result
        if ((is_array($operand1)) || (is_array($operand2))) {
            return $this->executeArrayComparison($operand1, $operand2, $operation, $stack, $recursingArrays);
        }

        $result = BinaryComparison::compare($operand1, $operand2, $operation);

        //    Log the result details
        $this->debugLog->writeDebugLog('Evaluation Result is %s', $this->showTypeDetails($result));
        //    And push the result onto the stack
        $stack->push('Value', $result);

        return $result;
    }

    private function executeNumericBinaryOperation(mixed $operand1, mixed $operand2, string $operation, Stack &$stack): mixed
    {
        //    Validate the two operands
        if (
            ($this->validateBinaryOperand($operand1, $stack) === false)
            || ($this->validateBinaryOperand($operand2, $stack) === false)
        ) {
            return false;
        }

        if (
            (Functions::getCompatibilityMode() != Functions::COMPATIBILITY_OPENOFFICE)
            && ((is_string($operand1) && !is_numeric($operand1) && $operand1 !== '')
                || (is_string($operand2) && !is_numeric($operand2) && $operand2 !== ''))
        ) {
            $result = ExcelError::VALUE();
        } elseif (is_array($operand1) || is_array($operand2)) {
            //    Ensure that both operands are arrays/matrices
            if (is_array($operand1)) {
                foreach ($operand1 as $key => $value) {
                    $operand1[$key] = Functions::flattenArray($value);
                }
            }
            if (is_array($operand2)) {
                foreach ($operand2 as $key => $value) {
                    $operand2[$key] = Functions::flattenArray($value);
                }
            }
            [$rows, $columns] = self::checkMatrixOperands($operand1, $operand2, 3);

            for ($row = 0; $row < $rows; ++$row) {
                for ($column = 0; $column < $columns; ++$column) {
                    if ($operand1[$row][$column] === null) {
                        $operand1[$row][$column] = 0;
                    } elseif (!self::isNumericOrBool($operand1[$row][$column])) {
                        $operand1[$row][$column] = self::makeError($operand1[$row][$column]);

                        continue;
                    }
                    if ($operand2[$row][$column] === null) {
                        $operand2[$row][$column] = 0;
                    } elseif (!self::isNumericOrBool($operand2[$row][$column])) {
                        $operand1[$row][$column] = self::makeError($operand2[$row][$column]);

                        continue;
                    }
                    switch ($operation) {
                        case '+':
                            $operand1[$row][$column] += $operand2[$row][$column];

                            break;
                        case '-':
                            $operand1[$row][$column] -= $operand2[$row][$column];

                            break;
                        case '*':
                            $operand1[$row][$column] *= $operand2[$row][$column];

                            break;
                        case '/':
                            if ($operand2[$row][$column] == 0) {
                                $operand1[$row][$column] = ExcelError::DIV0();
                            } else {
                                $operand1[$row][$column] /= $operand2[$row][$column];
                            }

                            break;
                        case '^':
                            $operand1[$row][$column] = $operand1[$row][$column] ** $operand2[$row][$column];

                            break;

                        default:
                            throw new Exception('Unsupported numeric binary operation');
                    }
                }
            }
            $result = $operand1;
        } else {
            //    If we're dealing with non-matrix operations, execute the necessary operation
            switch ($operation) {
                //    Addition
                case '+':
                    $result = $operand1 + $operand2;

                    break;
                //    Subtraction
                case '-':
                    $result = $operand1 - $operand2;

                    break;
                //    Multiplication
                case '*':
                    $result = $operand1 * $operand2;

                    break;
                //    Division
                case '/':
                    if ($operand2 == 0) {
                        //    Trap for Divide by Zero error
                        $stack->push('Error', ExcelError::DIV0());
                        $this->debugLog->writeDebugLog('Evaluation Result is %s', $this->showTypeDetails(ExcelError::DIV0()));

                        return false;
                    }
                    $result = $operand1 / $operand2;

                    break;
                //    Power
                case '^':
                    $result = $operand1 ** $operand2;

                    break;

                default:
                    throw new Exception('Unsupported numeric binary operation');
            }
        }

        //    Log the result details
        $this->debugLog->writeDebugLog('Evaluation Result is %s', $this->showTypeDetails($result));
        //    And push the result onto the stack
        $stack->push('Value', $result);

        return $result;
    }

    /**
     * Trigger an error, but nicely, if need be.
     *
     * @return false
     */
    protected function raiseFormulaError(string $errorMessage, int $code = 0, ?Throwable $exception = null): bool
    {
        $this->formulaError = $errorMessage;
        $this->cyclicReferenceStack->clear();
        $suppress = $this->suppressFormulaErrors;
        if (!$suppress) {
            throw new Exception($errorMessage, $code, $exception);
        }

        return false;
    }

    /**
     * Extract range values.
     *
     * @param string $range String based range representation
     * @param ?Worksheet $worksheet Worksheet
     * @param bool $resetLog Flag indicating whether calculation log should be reset or not
     *
     * @return array Array of values in range if range contains more than one element. Otherwise, a single value is returned.
     */
    public function extractCellRange(string &$range = 'A1', ?Worksheet $worksheet = null, bool $resetLog = true): array
    {
        // Return value
        $returnValue = [];

        if ($worksheet !== null) {
            $worksheetName = $worksheet->getTitle();

            if (str_contains($range, '!')) {
                [$worksheetName, $range] = Worksheet::extractSheetTitle($range, true);
                $worksheet = ($this->spreadsheet === null) ? null : $this->spreadsheet->getSheetByName($worksheetName);
            }

            // Extract range
            $aReferences = Coordinate::extractAllCellReferencesInRange($range);
            $range = "'" . $worksheetName . "'" . '!' . $range;
            $currentCol = '';
            $currentRow = 0;
            if (!isset($aReferences[1])) {
                //    Single cell in range
                sscanf($aReferences[0], '%[A-Z]%d', $currentCol, $currentRow);
                if ($worksheet !== null && $worksheet->cellExists($aReferences[0])) {
                    $temp = $worksheet->getCell($aReferences[0])->getCalculatedValue($resetLog);
                    if ($this->getInstanceArrayReturnType() === self::RETURN_ARRAY_AS_ARRAY) {
                        while (is_array($temp)) {
                            $temp = array_shift($temp);
                        }
                    }
                    $returnValue[$currentRow][$currentCol] = $temp;
                } else {
                    $returnValue[$currentRow][$currentCol] = null;
                }
            } else {
                // Extract cell data for all cells in the range
                foreach ($aReferences as $reference) {
                    // Extract range
                    sscanf($reference, '%[A-Z]%d', $currentCol, $currentRow);
                    if ($worksheet !== null && $worksheet->cellExists($reference)) {
                        $temp = $worksheet->getCell($reference)->getCalculatedValue($resetLog);
                        if ($this->getInstanceArrayReturnType() === self::RETURN_ARRAY_AS_ARRAY) {
                            while (is_array($temp)) {
                                $temp = array_shift($temp);
                            }
                        }
                        $returnValue[$currentRow][$currentCol] = $temp;
                    } else {
                        $returnValue[$currentRow][$currentCol] = null;
                    }
                }
            }
        }

        return $returnValue;
    }

    /**
     * Extract range values.
     *
     * @param string $range String based range representation
     * @param null|Worksheet $worksheet Worksheet
     * @param bool $resetLog Flag indicating whether calculation log should be reset or not
     *
     * @return array|string Array of values in range if range contains more than one element. Otherwise, a single value is returned.
     */
    public function extractNamedRange(string &$range = 'A1', ?Worksheet $worksheet = null, bool $resetLog = true): string|array
    {
        // Return value
        $returnValue = [];

        if ($worksheet !== null) {
            if (str_contains($range, '!')) {
                [$worksheetName, $range] = Worksheet::extractSheetTitle($range, true);
                $worksheet = ($this->spreadsheet === null) ? null : $this->spreadsheet->getSheetByName($worksheetName);
            }

            // Named range?
            $namedRange = ($worksheet === null) ? null : DefinedName::resolveName($range, $worksheet);
            if ($namedRange === null) {
                return ExcelError::REF();
            }

            $worksheet = $namedRange->getWorksheet();
            $range = $namedRange->getValue();
            $splitRange = Coordinate::splitRange($range);
            //    Convert row and column references
            if ($worksheet !== null && ctype_alpha($splitRange[0][0])) {
                $range = $splitRange[0][0] . '1:' . $splitRange[0][1] . $worksheet->getHighestRow();
            } elseif ($worksheet !== null && ctype_digit($splitRange[0][0])) {
                $range = 'A' . $splitRange[0][0] . ':' . $worksheet->getHighestColumn() . $splitRange[0][1];
            }

            // Extract range
            $aReferences = Coordinate::extractAllCellReferencesInRange($range);
            if (!isset($aReferences[1])) {
                //    Single cell (or single column or row) in range
                [$currentCol, $currentRow] = Coordinate::coordinateFromString($aReferences[0]);
                if ($worksheet !== null && $worksheet->cellExists($aReferences[0])) {
                    $returnValue[$currentRow][$currentCol] = $worksheet->getCell($aReferences[0])->getCalculatedValue($resetLog);
                } else {
                    $returnValue[$currentRow][$currentCol] = null;
                }
            } else {
                // Extract cell data for all cells in the range
                foreach ($aReferences as $reference) {
                    // Extract range
                    [$currentCol, $currentRow] = Coordinate::coordinateFromString($reference);
                    if ($worksheet !== null && $worksheet->cellExists($reference)) {
                        $returnValue[$currentRow][$currentCol] = $worksheet->getCell($reference)->getCalculatedValue($resetLog);
                    } else {
                        $returnValue[$currentRow][$currentCol] = null;
                    }
                }
            }
        }

        return $returnValue;
    }

    /**
     * Is a specific function implemented?
     *
     * @param string $function Function Name
     */
    public function isImplemented(string $function): bool
    {
        $function = strtoupper($function);
        $notImplemented = !isset(self::$phpSpreadsheetFunctions[$function]) || (is_array(self::$phpSpreadsheetFunctions[$function]['functionCall']) && self::$phpSpreadsheetFunctions[$function]['functionCall'][1] === 'DUMMY');

        return !$notImplemented;
    }

    /**
     * Get a list of all implemented functions as an array of function objects.
     */
    public static function getFunctions(): array
    {
        return self::$phpSpreadsheetFunctions;
    }

    /**
     * Get a list of implemented Excel function names.
     */
    public function getImplementedFunctionNames(): array
    {
        $returnValue = [];
        foreach (self::$phpSpreadsheetFunctions as $functionName => $function) {
            if ($this->isImplemented($functionName)) {
                $returnValue[] = $functionName;
            }
        }

        return $returnValue;
    }

    private function addDefaultArgumentValues(array $functionCall, array $args, array $emptyArguments): array
    {
        $reflector = new ReflectionMethod($functionCall[0], $functionCall[1]);
        $methodArguments = $reflector->getParameters();

        if (count($methodArguments) > 0) {
            // Apply any defaults for empty argument values
            foreach ($emptyArguments as $argumentId => $isArgumentEmpty) {
                if ($isArgumentEmpty === true) {
                    $reflectedArgumentId = count($args) - (int) $argumentId - 1;
                    if (
                        !array_key_exists($reflectedArgumentId, $methodArguments)
                        || $methodArguments[$reflectedArgumentId]->isVariadic()
                    ) {
                        break;
                    }

                    $args[$argumentId] = $this->getArgumentDefaultValue($methodArguments[$reflectedArgumentId]);
                }
            }
        }

        return $args;
    }

    private function getArgumentDefaultValue(ReflectionParameter $methodArgument): mixed
    {
        $defaultValue = null;

        if ($methodArgument->isDefaultValueAvailable()) {
            $defaultValue = $methodArgument->getDefaultValue();
            if ($methodArgument->isDefaultValueConstant()) {
                $constantName = $methodArgument->getDefaultValueConstantName() ?? '';
                // read constant value
                if (str_contains($constantName, '::')) {
                    [$className, $constantName] = explode('::', $constantName);
                    $constantReflector = new ReflectionClassConstant($className, $constantName);

                    return $constantReflector->getValue();
                }

                return constant($constantName);
            }
        }

        return $defaultValue;
    }

    /**
     * Add cell reference if needed while making sure that it is the last argument.
     */
    private function addCellReference(array $args, bool $passCellReference, array|string $functionCall, ?Cell $cell = null): array
    {
        if ($passCellReference) {
            if (is_array($functionCall)) {
                $className = $functionCall[0];
                $methodName = $functionCall[1];

                $reflectionMethod = new ReflectionMethod($className, $methodName);
                $argumentCount = count($reflectionMethod->getParameters());
                while (count($args) < $argumentCount - 1) {
                    $args[] = null;
                }
            }

            $args[] = $cell;
        }

        return $args;
    }

    private function evaluateDefinedName(Cell $cell, DefinedName $namedRange, Worksheet $cellWorksheet, Stack $stack, bool $ignoreScope = false): mixed
    {
        $definedNameScope = $namedRange->getScope();
        if ($definedNameScope !== null && $definedNameScope !== $cellWorksheet && !$ignoreScope) {
            // The defined name isn't in our current scope, so #REF
            $result = ExcelError::REF();
            $stack->push('Error', $result, $namedRange->getName());

            return $result;
        }

        $definedNameValue = $namedRange->getValue();
        $definedNameType = $namedRange->isFormula() ? 'Formula' : 'Range';
        $definedNameWorksheet = $namedRange->getWorksheet();

        if ($definedNameValue[0] !== '=') {
            $definedNameValue = '=' . $definedNameValue;
        }

        $this->debugLog->writeDebugLog('Defined Name is a %s with a value of %s', $definedNameType, $definedNameValue);

        $originalCoordinate = $cell->getCoordinate();
        $recursiveCalculationCell = ($definedNameType !== 'Formula' && $definedNameWorksheet !== null && $definedNameWorksheet !== $cellWorksheet)
            ? $definedNameWorksheet->getCell('A1')
            : $cell;
        $recursiveCalculationCellAddress = $recursiveCalculationCell->getCoordinate();

        // Adjust relative references in ranges and formulae so that we execute the calculation for the correct rows and columns
        $definedNameValue = self::$referenceHelper->updateFormulaReferencesAnyWorksheet(
            $definedNameValue,
            Coordinate::columnIndexFromString($cell->getColumn()) - 1,
            $cell->getRow() - 1
        );

        $this->debugLog->writeDebugLog('Value adjusted for relative references is %s', $definedNameValue);

        $recursiveCalculator = new self($this->spreadsheet);
        $recursiveCalculator->getDebugLog()->setWriteDebugLog($this->getDebugLog()->getWriteDebugLog());
        $recursiveCalculator->getDebugLog()->setEchoDebugLog($this->getDebugLog()->getEchoDebugLog());
        $result = $recursiveCalculator->_calculateFormulaValue($definedNameValue, $recursiveCalculationCellAddress, $recursiveCalculationCell, true);
        $cellWorksheet->getCell($originalCoordinate);

        if ($this->getDebugLog()->getWriteDebugLog()) {
            $this->debugLog->mergeDebugLog(array_slice($recursiveCalculator->getDebugLog()->getLog(), 3));
            $this->debugLog->writeDebugLog('Evaluation Result for Named %s %s is %s', $definedNameType, $namedRange->getName(), $this->showTypeDetails($result));
        }

        $stack->push('Defined Name', $result, $namedRange->getName());

        return $result;
    }

    public function setSuppressFormulaErrors(bool $suppressFormulaErrors): void
    {
        $this->suppressFormulaErrors = $suppressFormulaErrors;
    }

    public function getSuppressFormulaErrors(): bool
    {
        return $this->suppressFormulaErrors;
    }

    public static function boolToString(mixed $operand1): mixed
    {
        if (is_bool($operand1)) {
            $operand1 = ($operand1) ? self::$localeBoolean['TRUE'] : self::$localeBoolean['FALSE'];
        } elseif ($operand1 === null) {
            $operand1 = '';
        }

        return $operand1;
    }

    private static function isNumericOrBool(mixed $operand): bool
    {
        return is_numeric($operand) || is_bool($operand);
    }

    private static function makeError(mixed $operand = ''): string
    {
        return Information\ErrorValue::isError($operand) ? $operand : ExcelError::VALUE();
    }
}	
?>