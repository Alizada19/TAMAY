<?php 
//namespace PhpOffice\PhpSpreadsheet\Calculationparts;
//use PhpOffice\PhpSpreadsheet\Calculationparts2;
class Calculationparts 
{
	
  public function __construct(?Spreadsheet $spreadsheet = null)
    {
        $this->spreadsheet = $spreadsheet;
        $this->cyclicReferenceStack = new CyclicReferenceStack();
        $this->debugLog = new Logger($this->cyclicReferenceStack);
        $this->branchPruner = new BranchPruner($this->branchPruningEnabled);
        self::$referenceHelper = ReferenceHelper::getInstance();
    }

    private static function loadLocales(): void
    {
        $localeFileDirectory = __DIR__ . '/locale/';
        $localeFileNames = glob($localeFileDirectory . '*', GLOB_ONLYDIR) ?: [];
        foreach ($localeFileNames as $filename) {
            $filename = substr($filename, strlen($localeFileDirectory));
            if ($filename != 'en') {
                self::$validLocaleLanguages[] = $filename;
            }
        }
    }

    /**
     * Get an instance of this class.
     *
     * @param ?Spreadsheet $spreadsheet Injected spreadsheet for working with a PhpSpreadsheet Spreadsheet object,
     *                                    or NULL to create a standalone calculation engine
     */
    public static function getInstance(?Spreadsheet $spreadsheet = null): self
    {
        if ($spreadsheet !== null) {
            $instance = $spreadsheet->getCalculationEngine();
            if (isset($instance)) {
                return $instance;
            }
        }

        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Flush the calculation cache for any existing instance of this class
     *        but only if a Calculation instance exists.
     */
    public function flushInstance(): void
    {
        $this->clearCalculationCache();
        $this->branchPruner->clearBranchStore();
    }

    /**
     * Get the Logger for this calculation engine instance.
     */
    public function getDebugLog(): Logger
    {
        return $this->debugLog;
    }

    /**
     * __clone implementation. Cloning should not be allowed in a Singleton!
     */
    final public function __clone()
    {
        throw new Exception('Cloning the calculation engine is not allowed!');
    }

    /**
     * Return the locale-specific translation of TRUE.
     *
     * @return string locale-specific translation of TRUE
     */
    public static function getTRUE(): string
    {
        return self::$localeBoolean['TRUE'];
    }

    /**
     * Return the locale-specific translation of FALSE.
     *
     * @return string locale-specific translation of FALSE
     */
    public static function getFALSE(): string
    {
        return self::$localeBoolean['FALSE'];
    }

    /**
     * Set the Array Return Type (Array or Value of first element in the array).
     *
     * @param string $returnType Array return type
     *
     * @return bool Success or failure
     */
    public static function setArrayReturnType(string $returnType): bool
    {
        if (
            ($returnType == self::RETURN_ARRAY_AS_VALUE)
            || ($returnType == self::RETURN_ARRAY_AS_ERROR)
            || ($returnType == self::RETURN_ARRAY_AS_ARRAY)
        ) {
            self::$returnArrayAsType = $returnType;

            return true;
        }

        return false;
    }

    /**
     * Return the Array Return Type (Array or Value of first element in the array).
     *
     * @return string $returnType Array return type
     */
    public static function getArrayReturnType(): string
    {
        return self::$returnArrayAsType;
    }

    /**
     * Set the Instance Array Return Type (Array or Value of first element in the array).
     *
     * @param string $returnType Array return type
     *
     * @return bool Success or failure
     */
    public function setInstanceArrayReturnType(string $returnType): bool
    {
        if (
            ($returnType == self::RETURN_ARRAY_AS_VALUE)
            || ($returnType == self::RETURN_ARRAY_AS_ERROR)
            || ($returnType == self::RETURN_ARRAY_AS_ARRAY)
        ) {
            $this->instanceArrayReturnType = $returnType;

            return true;
        }

        return false;
    }

    /**
     * Return the Array Return Type (Array or Value of first element in the array).
     *
     * @return string $returnType Array return type for instance if non-null, otherwise static property
     */
    public function getInstanceArrayReturnType(): string
    {
        return $this->instanceArrayReturnType ?? self::$returnArrayAsType;
    }

    /**
     * Is calculation caching enabled?
     */
    public function getCalculationCacheEnabled(): bool
    {
        return $this->calculationCacheEnabled;
    }

    /**
     * Enable/disable calculation cache.
     */
    public function setCalculationCacheEnabled(bool $calculationCacheEnabled): void
    {
        $this->calculationCacheEnabled = $calculationCacheEnabled;
        $this->clearCalculationCache();
    }

    /**
     * Enable calculation cache.
     */
    public function enableCalculationCache(): void
    {
        $this->setCalculationCacheEnabled(true);
    }

    /**
     * Disable calculation cache.
     */
    public function disableCalculationCache(): void
    {
        $this->setCalculationCacheEnabled(false);
    }

    /**
     * Clear calculation cache.
     */
    public function clearCalculationCache(): void
    {
        $this->calculationCache = [];
    }

    /**
     * Clear calculation cache for a specified worksheet.
     */
    public function clearCalculationCacheForWorksheet(string $worksheetName): void
    {
        if (isset($this->calculationCache[$worksheetName])) {
            unset($this->calculationCache[$worksheetName]);
        }
    }

    /**
     * Rename calculation cache for a specified worksheet.
     */
    public function renameCalculationCacheForWorksheet(string $fromWorksheetName, string $toWorksheetName): void
    {
        if (isset($this->calculationCache[$fromWorksheetName])) {
            $this->calculationCache[$toWorksheetName] = &$this->calculationCache[$fromWorksheetName];
            unset($this->calculationCache[$fromWorksheetName]);
        }
    }

    /**
     * Enable/disable calculation cache.
     */
    public function setBranchPruningEnabled(mixed $enabled): void
    {
        $this->branchPruningEnabled = $enabled;
        $this->branchPruner = new BranchPruner($this->branchPruningEnabled);
    }

    public function enableBranchPruning(): void
    {
        $this->setBranchPruningEnabled(true);
    }

    public function disableBranchPruning(): void
    {
        $this->setBranchPruningEnabled(false);
    }

    /**
     * Get the currently defined locale code.
     */
    public function getLocale(): string
    {
        return self::$localeLanguage;
    }

    private function getLocaleFile(string $localeDir, string $locale, string $language, string $file): string
    {
        $localeFileName = $localeDir . str_replace('_', DIRECTORY_SEPARATOR, $locale)
            . DIRECTORY_SEPARATOR . $file;
        if (!file_exists($localeFileName)) {
            //    If there isn't a locale specific file, look for a language specific file
            $localeFileName = $localeDir . $language . DIRECTORY_SEPARATOR . $file;
            if (!file_exists($localeFileName)) {
                throw new Exception('Locale file not found');
            }
        }

        return $localeFileName;
    }

    /**
     * Set the locale code.
     *
     * @param string $locale The locale to use for formula translation, eg: 'en_us'
     */
    public function setLocale(string $locale): bool
    {
        //    Identify our locale and language
        $language = $locale = strtolower($locale);
        if (str_contains($locale, '_')) {
            [$language] = explode('_', $locale);
        }
        if (count(self::$validLocaleLanguages) == 1) {
            self::loadLocales();
        }

        //    Test whether we have any language data for this language (any locale)
        if (in_array($language, self::$validLocaleLanguages, true)) {
            //    initialise language/locale settings
            self::$localeFunctions = [];
            self::$localeArgumentSeparator = ',';
            self::$localeBoolean = ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NULL' => 'NULL'];

            //    Default is US English, if user isn't requesting US english, then read the necessary data from the locale files
            if ($locale !== 'en_us') {
                $localeDir = implode(DIRECTORY_SEPARATOR, [__DIR__, 'locale', null]);

                //    Search for a file with a list of function names for locale
                try {
                    $functionNamesFile = $this->getLocaleFile($localeDir, $locale, $language, 'functions');
                } catch (Exception $e) {
                    return false;
                }

                //    Retrieve the list of locale or language specific function names
                $localeFunctions = file($functionNamesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
                foreach ($localeFunctions as $localeFunction) {
                    [$localeFunction] = explode('##', $localeFunction); //    Strip out comments
                    if (str_contains($localeFunction, '=')) {
                        [$fName, $lfName] = array_map('trim', explode('=', $localeFunction));
                        if ((str_starts_with($fName, '*') || isset(self::$phpSpreadsheetFunctions[$fName])) && ($lfName != '') && ($fName != $lfName)) {
                            self::$localeFunctions[$fName] = $lfName;
                        }
                    }
                }
                //    Default the TRUE and FALSE constants to the locale names of the TRUE() and FALSE() functions
                if (isset(self::$localeFunctions['TRUE'])) {
                    self::$localeBoolean['TRUE'] = self::$localeFunctions['TRUE'];
                }
                if (isset(self::$localeFunctions['FALSE'])) {
                    self::$localeBoolean['FALSE'] = self::$localeFunctions['FALSE'];
                }

                try {
                    $configFile = $this->getLocaleFile($localeDir, $locale, $language, 'config');
                } catch (Exception) {
                    return false;
                }

                $localeSettings = file($configFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
                foreach ($localeSettings as $localeSetting) {
                    [$localeSetting] = explode('##', $localeSetting); //    Strip out comments
                    if (str_contains($localeSetting, '=')) {
                        [$settingName, $settingValue] = array_map('trim', explode('=', $localeSetting));
                        $settingName = strtoupper($settingName);
                        if ($settingValue !== '') {
                            switch ($settingName) {
                                case 'ARGUMENTSEPARATOR':
                                    self::$localeArgumentSeparator = $settingValue;

                                    break;
                            }
                        }
                    }
                }
            }

            self::$functionReplaceFromExcel = self::$functionReplaceToExcel
            = self::$functionReplaceFromLocale = self::$functionReplaceToLocale = null;
            self::$localeLanguage = $locale;

            return true;
        }

        return false;
    }

    public static function translateSeparator(
        string $fromSeparator,
        string $toSeparator,
        string $formula,
        int &$inBracesLevel,
        string $openBrace = self::FORMULA_OPEN_FUNCTION_BRACE,
        string $closeBrace = self::FORMULA_CLOSE_FUNCTION_BRACE
    ): string {
        $strlen = mb_strlen($formula);
        for ($i = 0; $i < $strlen; ++$i) {
            $chr = mb_substr($formula, $i, 1);
            switch ($chr) {
                case $openBrace:
                    ++$inBracesLevel;

                    break;
                case $closeBrace:
                    --$inBracesLevel;

                    break;
                case $fromSeparator:
                    if ($inBracesLevel > 0) {
                        $formula = mb_substr($formula, 0, $i) . $toSeparator . mb_substr($formula, $i + 1);
                    }
            }
        }

        return $formula;
    }

    private static function translateFormulaBlock(
        array $from,
        array $to,
        string $formula,
        int &$inFunctionBracesLevel,
        int &$inMatrixBracesLevel,
        string $fromSeparator,
        string $toSeparator
    ): string {
        // Function Names
        $formula = (string) preg_replace($from, $to, $formula);

        // Temporarily adjust matrix separators so that they won't be confused with function arguments
        $formula = self::translateSeparator(';', '|', $formula, $inMatrixBracesLevel, self::FORMULA_OPEN_MATRIX_BRACE, self::FORMULA_CLOSE_MATRIX_BRACE);
        $formula = self::translateSeparator(',', '!', $formula, $inMatrixBracesLevel, self::FORMULA_OPEN_MATRIX_BRACE, self::FORMULA_CLOSE_MATRIX_BRACE);
        // Function Argument Separators
        $formula = self::translateSeparator($fromSeparator, $toSeparator, $formula, $inFunctionBracesLevel);
        // Restore matrix separators
        $formula = self::translateSeparator('|', ';', $formula, $inMatrixBracesLevel, self::FORMULA_OPEN_MATRIX_BRACE, self::FORMULA_CLOSE_MATRIX_BRACE);
        $formula = self::translateSeparator('!', ',', $formula, $inMatrixBracesLevel, self::FORMULA_OPEN_MATRIX_BRACE, self::FORMULA_CLOSE_MATRIX_BRACE);

        return $formula;
    }

    private static function translateFormula(array $from, array $to, string $formula, string $fromSeparator, string $toSeparator): string
    {
        // Convert any Excel function names and constant names to the required language;
        //     and adjust function argument separators
        if (self::$localeLanguage !== 'en_us') {
            $inFunctionBracesLevel = 0;
            $inMatrixBracesLevel = 0;
            //    If there is the possibility of separators within a quoted string, then we treat them as literals
            if (str_contains($formula, self::FORMULA_STRING_QUOTE)) {
                //    So instead we skip replacing in any quoted strings by only replacing in every other array element
                //       after we've exploded the formula
                $temp = explode(self::FORMULA_STRING_QUOTE, $formula);
                $notWithinQuotes = false;
                foreach ($temp as &$value) {
                    //    Only adjust in alternating array entries
                    $notWithinQuotes = $notWithinQuotes === false;
                    if ($notWithinQuotes === true) {
                        $value = self::translateFormulaBlock($from, $to, $value, $inFunctionBracesLevel, $inMatrixBracesLevel, $fromSeparator, $toSeparator);
                    }
                }
                unset($value);
                //    Then rebuild the formula string
                $formula = implode(self::FORMULA_STRING_QUOTE, $temp);
            } else {
                //    If there's no quoted strings, then we do a simple count/replace
                $formula = self::translateFormulaBlock($from, $to, $formula, $inFunctionBracesLevel, $inMatrixBracesLevel, $fromSeparator, $toSeparator);
            }
        }

        return $formula;
    }

    private static ?array $functionReplaceFromExcel;

    private static ?array $functionReplaceToLocale;

    public function translateFormulaToLocale(string $formula): string
    {
        $formula = preg_replace(self::CALCULATION_REGEXP_STRIP_XLFN_XLWS, '', $formula) ?? '';
        // Build list of function names and constants for translation
        if (self::$functionReplaceFromExcel === null) {
            self::$functionReplaceFromExcel = [];
            foreach (array_keys(self::$localeFunctions) as $excelFunctionName) {
                self::$functionReplaceFromExcel[] = '/(@?[^\w\.])' . preg_quote($excelFunctionName, '/') . '([\s]*\()/ui';
            }
            foreach (array_keys(self::$localeBoolean) as $excelBoolean) {
                self::$functionReplaceFromExcel[] = '/(@?[^\w\.])' . preg_quote($excelBoolean, '/') . '([^\w\.])/ui';
            }
        }

        if (self::$functionReplaceToLocale === null) {
            self::$functionReplaceToLocale = [];
            foreach (self::$localeFunctions as $localeFunctionName) {
                self::$functionReplaceToLocale[] = '$1' . trim($localeFunctionName) . '$2';
            }
            foreach (self::$localeBoolean as $localeBoolean) {
                self::$functionReplaceToLocale[] = '$1' . trim($localeBoolean) . '$2';
            }
        }

        return self::translateFormula(
            self::$functionReplaceFromExcel,
            self::$functionReplaceToLocale,
            $formula,
            ',',
            self::$localeArgumentSeparator
        );
    }

    private static ?array $functionReplaceFromLocale;

    private static ?array $functionReplaceToExcel;

    public function translateFormulaToEnglish(string $formula): string
    {
        if (self::$functionReplaceFromLocale === null) {
            self::$functionReplaceFromLocale = [];
            foreach (self::$localeFunctions as $localeFunctionName) {
                self::$functionReplaceFromLocale[] = '/(@?[^\w\.])' . preg_quote($localeFunctionName, '/') . '([\s]*\()/ui';
            }
            foreach (self::$localeBoolean as $excelBoolean) {
                self::$functionReplaceFromLocale[] = '/(@?[^\w\.])' . preg_quote($excelBoolean, '/') . '([^\w\.])/ui';
            }
        }

        if (self::$functionReplaceToExcel === null) {
            self::$functionReplaceToExcel = [];
            foreach (array_keys(self::$localeFunctions) as $excelFunctionName) {
                self::$functionReplaceToExcel[] = '$1' . trim($excelFunctionName) . '$2';
            }
            foreach (array_keys(self::$localeBoolean) as $excelBoolean) {
                self::$functionReplaceToExcel[] = '$1' . trim($excelBoolean) . '$2';
            }
        }

        return self::translateFormula(self::$functionReplaceFromLocale, self::$functionReplaceToExcel, $formula, self::$localeArgumentSeparator, ',');
    }

    public static function localeFunc(string $function): string
    {
        if (self::$localeLanguage !== 'en_us') {
            $functionName = trim($function, '(');
            if (isset(self::$localeFunctions[$functionName])) {
                $brace = ($functionName != $function);
                $function = self::$localeFunctions[$functionName];
                if ($brace) {
                    $function .= '(';
                }
            }
        }

        return $function;
    }

    /**
     * Wrap string values in quotes.
     */
    public static function wrapResult(mixed $value): mixed
    {
        if (is_string($value)) {
            //    Error values cannot be "wrapped"
            if (preg_match('/^' . self::CALCULATION_REGEXP_ERROR . '$/i', $value, $match)) {
                //    Return Excel errors "as is"
                return $value;
            }

            //    Return strings wrapped in quotes
            return self::FORMULA_STRING_QUOTE . $value . self::FORMULA_STRING_QUOTE;
        } elseif ((is_float($value)) && ((is_nan($value)) || (is_infinite($value)))) {
            //    Convert numeric errors to NaN error
            return ExcelError::NAN();
        }

        return $value;
    }

    /**
     * Remove quotes used as a wrapper to identify string values.
     */
    public static function unwrapResult(mixed $value): mixed
    {
        if (is_string($value)) {
            if ((isset($value[0])) && ($value[0] == self::FORMULA_STRING_QUOTE) && (substr($value, -1) == self::FORMULA_STRING_QUOTE)) {
                return substr($value, 1, -1);
            }
            //    Convert numeric errors to NAN error
        } elseif ((is_float($value)) && ((is_nan($value)) || (is_infinite($value)))) {
            return ExcelError::NAN();
        }

        return $value;
    }

    /**
     * Calculate cell value (using formula from a cell ID)
     * Retained for backward compatibility.
     *
     * @param ?Cell $cell Cell to calculate
     */
    public function calculate(?Cell $cell = null): mixed
    {
        try {
            return $this->calculateCellValue($cell);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Calculate the value of a cell formula.
     *
     * @param ?Cell $cell Cell to calculate
     * @param bool $resetLog Flag indicating whether the debug log should be reset or not
     */
    public function calculateCellValue(?Cell $cell = null, bool $resetLog = true): mixed
    {
        if ($cell === null) {
            return null;
        }

        if ($resetLog) {
            //    Initialise the logging settings if requested
            $this->formulaError = null;
            $this->debugLog->clearLog();
            $this->cyclicReferenceStack->clear();
            $this->cyclicFormulaCounter = 1;
        }

        //    Execute the calculation for the cell formula
        $this->cellStack[] = [
            'sheet' => $cell->getWorksheet()->getTitle(),
            'cell' => $cell->getCoordinate(),
        ];

        $cellAddressAttempted = false;
        $cellAddress = null;

        try {
            $value = $cell->getValue();
            if ($cell->getDataType() === DataType::TYPE_FORMULA) {
                $value = preg_replace_callback(
                    self::CALCULATION_REGEXP_CELLREF_SPILL,
                    fn (array $matches) => 'ANCHORARRAY(' . substr($matches[0], 0, -1) . ')',
                    $value
                );
            }
            $result = self::unwrapResult($this->_calculateFormulaValue($value, $cell->getCoordinate(), $cell));
            if ($this->spreadsheet === null) {
                throw new Exception('null spreadsheet in calculateCellValue');
            }
            $cellAddressAttempted = true;
            $cellAddress = array_pop($this->cellStack);
            if ($cellAddress === null) {
                throw new Exception('null cellAddress in calculateCellValue');
            }
            $testSheet = $this->spreadsheet->getSheetByName($cellAddress['sheet']);
            if ($testSheet === null) {
                throw new Exception('worksheet not found in calculateCellValue');
            }
            $testSheet->getCell($cellAddress['cell']);
        } catch (\Exception $e) {
            if (!$cellAddressAttempted) {
                $cellAddress = array_pop($this->cellStack);
            }
            if ($this->spreadsheet !== null && is_array($cellAddress) && array_key_exists('sheet', $cellAddress)) {
                $testSheet = $this->spreadsheet->getSheetByName($cellAddress['sheet']);
                if ($testSheet !== null && array_key_exists('cell', $cellAddress)) {
                    $testSheet->getCell($cellAddress['cell']);
                }
            }

            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        if (is_array($result) && $this->getInstanceArrayReturnType() !== self::RETURN_ARRAY_AS_ARRAY) {
            $testResult = Functions::flattenArray($result);
            if ($this->getInstanceArrayReturnType() == self::RETURN_ARRAY_AS_ERROR) {
                return ExcelError::VALUE();
            }
            $result = array_shift($testResult);
        }

        if ($result === null && $cell->getWorksheet()->getSheetView()->getShowZeros()) {
            return 0;
        } elseif ((is_float($result)) && ((is_nan($result)) || (is_infinite($result)))) {
            return ExcelError::NAN();
        }

        return $result;
    }

    /**
     * Validate and parse a formula string.
     *
     * @param string $formula Formula to parse
     */
    public function parseFormula(string $formula): array|bool
    {
        $formula = preg_replace_callback(
            self::CALCULATION_REGEXP_CELLREF_SPILL,
            fn (array $matches) => 'ANCHORARRAY(' . substr($matches[0], 0, -1) . ')',
            $formula
        ) ?? $formula;
        //    Basic validation that this is indeed a formula
        //    We return an empty array if not
        $formula = trim($formula);
        if ((!isset($formula[0])) || ($formula[0] != '=')) {
            return [];
        }
        $formula = ltrim(substr($formula, 1));
        if (!isset($formula[0])) {
            return [];
        }

        //    Parse the formula and return the token stack
        return $this->internalParseFormula($formula);
    }

    /**
     * Calculate the value of a formula.
     *
     * @param string $formula Formula to parse
     * @param ?string $cellID Address of the cell to calculate
     * @param ?Cell $cell Cell to calculate
     */
    public function calculateFormula(string $formula, ?string $cellID = null, ?Cell $cell = null): mixed
    {
        //    Initialise the logging settings
        $this->formulaError = null;
        $this->debugLog->clearLog();
        $this->cyclicReferenceStack->clear();

        $resetCache = $this->getCalculationCacheEnabled();
        if ($this->spreadsheet !== null && $cellID === null && $cell === null) {
            $cellID = 'A1';
            $cell = $this->spreadsheet->getActiveSheet()->getCell($cellID);
        } else {
            //    Disable calculation cacheing because it only applies to cell calculations, not straight formulae
            //    But don't actually flush any cache
            $this->calculationCacheEnabled = false;
        }

        //    Execute the calculation
        try {
            $result = self::unwrapResult($this->_calculateFormulaValue($formula, $cellID, $cell));
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        if ($this->spreadsheet === null) {
            //    Reset calculation cacheing to its previous state
            $this->calculationCacheEnabled = $resetCache;
        }

        return $result;
    }

    public function getValueFromCache(string $cellReference, mixed &$cellValue): bool
    {
        $this->debugLog->writeDebugLog('Testing cache value for cell %s', $cellReference);
        // Is calculation cacheing enabled?
        // If so, is the required value present in calculation cache?
        if (($this->calculationCacheEnabled) && (isset($this->calculationCache[$cellReference]))) {
            $this->debugLog->writeDebugLog('Retrieving value for cell %s from cache', $cellReference);
            // Return the cached result

            $cellValue = $this->calculationCache[$cellReference];

            return true;
        }

        return false;
    }

    public function saveValueToCache(string $cellReference, mixed $cellValue): void
    {
        if ($this->calculationCacheEnabled) {
            $this->calculationCache[$cellReference] = $cellValue;
        }
    }

    /**
     * Parse a cell formula and calculate its value.
     *
     * @param string $formula The formula to parse and calculate
     * @param ?string $cellID The ID (e.g. A3) of the cell that we are calculating
     * @param ?Cell $cell Cell to calculate
     * @param bool $ignoreQuotePrefix If set to true, evaluate the formyla even if the referenced cell is quote prefixed
     */
    public function _calculateFormulaValue(string $formula, ?string $cellID = null, ?Cell $cell = null, bool $ignoreQuotePrefix = false): mixed
    {
        $cellValue = null;

        //  Quote-Prefixed cell values cannot be formulae, but are treated as strings
        if ($cell !== null && $ignoreQuotePrefix === false && $cell->getStyle()->getQuotePrefix() === true) {
            return self::wrapResult((string) $formula);
        }

        if (preg_match('/^=\s*cmd\s*\|/miu', $formula) !== 0) {
            return self::wrapResult($formula);
        }

        //    Basic validation that this is indeed a formula
        //    We simply return the cell value if not
        $formula = trim($formula);
        if ($formula === '' || $formula[0] !== '=') {
            return self::wrapResult($formula);
        }
        $formula = ltrim(substr($formula, 1));
        if (!isset($formula[0])) {
            return self::wrapResult($formula);
        }

        $pCellParent = ($cell !== null) ? $cell->getWorksheet() : null;
        $wsTitle = ($pCellParent !== null) ? $pCellParent->getTitle() : "\x00Wrk";
        $wsCellReference = $wsTitle . '!' . $cellID;

        if (($cellID !== null) && ($this->getValueFromCache($wsCellReference, $cellValue))) {
            return $cellValue;
        }
        $this->debugLog->writeDebugLog('Evaluating formula for cell %s', $wsCellReference);

        if (($wsTitle[0] !== "\x00") && ($this->cyclicReferenceStack->onStack($wsCellReference))) {
            if ($this->cyclicFormulaCount <= 0) {
                $this->cyclicFormulaCell = '';

                return $this->raiseFormulaError('Cyclic Reference in Formula');
            } elseif ($this->cyclicFormulaCell === $wsCellReference) {
                ++$this->cyclicFormulaCounter;
                if ($this->cyclicFormulaCounter >= $this->cyclicFormulaCount) {
                    $this->cyclicFormulaCell = '';

                    return $cellValue;
                }
            } elseif ($this->cyclicFormulaCell == '') {
                if ($this->cyclicFormulaCounter >= $this->cyclicFormulaCount) {
                    return $cellValue;
                }
                $this->cyclicFormulaCell = $wsCellReference;
            }
        }

        $this->debugLog->writeDebugLog('Formula for cell %s is %s', $wsCellReference, $formula);
        //    Parse the formula onto the token stack and calculate the value
        $this->cyclicReferenceStack->push($wsCellReference);

        $cellValue = $this->processTokenStack($this->internalParseFormula($formula, $cell), $cellID, $cell);
        $this->cyclicReferenceStack->pop();

        // Save to calculation cache
        if ($cellID !== null) {
            $this->saveValueToCache($wsCellReference, $cellValue);
        }

        //    Return the calculated value
        return $cellValue;
    }

    /**
     * Ensure that paired matrix operands are both matrices and of the same size.
     *
     * @param mixed $operand1 First matrix operand
     * @param mixed $operand2 Second matrix operand
     * @param int $resize Flag indicating whether the matrices should be resized to match
     *                                        and (if so), whether the smaller dimension should grow or the
     *                                        larger should shrink.
     *                                            0 = no resize
     *                                            1 = shrink to fit
     *                                            2 = extend to fit
     */
    public static function checkMatrixOperands(mixed &$operand1, mixed &$operand2, int $resize = 1): array
    {
        //    Examine each of the two operands, and turn them into an array if they aren't one already
        //    Note that this function should only be called if one or both of the operand is already an array
        if (!is_array($operand1)) {
            [$matrixRows, $matrixColumns] = self::getMatrixDimensions($operand2);
            $operand1 = array_fill(0, $matrixRows, array_fill(0, $matrixColumns, $operand1));
            $resize = 0;
        } elseif (!is_array($operand2)) {
            [$matrixRows, $matrixColumns] = self::getMatrixDimensions($operand1);
            $operand2 = array_fill(0, $matrixRows, array_fill(0, $matrixColumns, $operand2));
            $resize = 0;
        }

        [$matrix1Rows, $matrix1Columns] = self::getMatrixDimensions($operand1);
        [$matrix2Rows, $matrix2Columns] = self::getMatrixDimensions($operand2);
        if ($resize === 3) {
            $resize = 2;
        } elseif (($matrix1Rows == $matrix2Columns) && ($matrix2Rows == $matrix1Columns)) {
            $resize = 1;
        }

        if ($resize == 2) {
            //    Given two matrices of (potentially) unequal size, convert the smaller in each dimension to match the larger
            self::resizeMatricesExtend($operand1, $operand2, $matrix1Rows, $matrix1Columns, $matrix2Rows, $matrix2Columns);
        } elseif ($resize == 1) {
            //    Given two matrices of (potentially) unequal size, convert the larger in each dimension to match the smaller
            self::resizeMatricesShrink($operand1, $operand2, $matrix1Rows, $matrix1Columns, $matrix2Rows, $matrix2Columns);
        }
        [$matrix1Rows, $matrix1Columns] = self::getMatrixDimensions($operand1);
        [$matrix2Rows, $matrix2Columns] = self::getMatrixDimensions($operand2);

        return [$matrix1Rows, $matrix1Columns, $matrix2Rows, $matrix2Columns];
    }

    /**
     * Read the dimensions of a matrix, and re-index it with straight numeric keys starting from row 0, column 0.
     *
     * @param array $matrix matrix operand
     *
     * @return int[] An array comprising the number of rows, and number of columns
     */
    public static function getMatrixDimensions(array &$matrix): array
    {
        $matrixRows = count($matrix);
        $matrixColumns = 0;
        foreach ($matrix as $rowKey => $rowValue) {
            if (!is_array($rowValue)) {
                $matrix[$rowKey] = [$rowValue];
                $matrixColumns = max(1, $matrixColumns);
            } else {
                $matrix[$rowKey] = array_values($rowValue);
                $matrixColumns = max(count($rowValue), $matrixColumns);
            }
        }
        $matrix = array_values($matrix);

        return [$matrixRows, $matrixColumns];
    }

    /**
     * Ensure that paired matrix operands are both matrices of the same size.
     *
     * @param array $matrix1 First matrix operand
     * @param array $matrix2 Second matrix operand
     * @param int $matrix1Rows Row size of first matrix operand
     * @param int $matrix1Columns Column size of first matrix operand
     * @param int $matrix2Rows Row size of second matrix operand
     * @param int $matrix2Columns Column size of second matrix operand
     */
    private static function resizeMatricesShrink(array &$matrix1, array &$matrix2, int $matrix1Rows, int $matrix1Columns, int $matrix2Rows, int $matrix2Columns): void
    {
        if (($matrix2Columns < $matrix1Columns) || ($matrix2Rows < $matrix1Rows)) {
            if ($matrix2Rows < $matrix1Rows) {
                for ($i = $matrix2Rows; $i < $matrix1Rows; ++$i) {
                    unset($matrix1[$i]);
                }
            }
            if ($matrix2Columns < $matrix1Columns) {
                for ($i = 0; $i < $matrix1Rows; ++$i) {
                    for ($j = $matrix2Columns; $j < $matrix1Columns; ++$j) {
                        unset($matrix1[$i][$j]);
                    }
                }
            }
        }

        if (($matrix1Columns < $matrix2Columns) || ($matrix1Rows < $matrix2Rows)) {
            if ($matrix1Rows < $matrix2Rows) {
                for ($i = $matrix1Rows; $i < $matrix2Rows; ++$i) {
                    unset($matrix2[$i]);
                }
            }
            if ($matrix1Columns < $matrix2Columns) {
                for ($i = 0; $i < $matrix2Rows; ++$i) {
                    for ($j = $matrix1Columns; $j < $matrix2Columns; ++$j) {
                        unset($matrix2[$i][$j]);
                    }
                }
            }
        }
    }

    /**
     * Ensure that paired matrix operands are both matrices of the same size.
     *
     * @param array $matrix1 First matrix operand
     * @param array $matrix2 Second matrix operand
     * @param int $matrix1Rows Row size of first matrix operand
     * @param int $matrix1Columns Column size of first matrix operand
     * @param int $matrix2Rows Row size of second matrix operand
     * @param int $matrix2Columns Column size of second matrix operand
     */
    private static function resizeMatricesExtend(array &$matrix1, array &$matrix2, int $matrix1Rows, int $matrix1Columns, int $matrix2Rows, int $matrix2Columns): void
    {
        if (($matrix2Columns < $matrix1Columns) || ($matrix2Rows < $matrix1Rows)) {
            if ($matrix2Columns < $matrix1Columns) {
                for ($i = 0; $i < $matrix2Rows; ++$i) {
                    $x = $matrix2[$i][$matrix2Columns - 1];
                    for ($j = $matrix2Columns; $j < $matrix1Columns; ++$j) {
                        $matrix2[$i][$j] = $x;
                    }
                }
            }
            if ($matrix2Rows < $matrix1Rows) {
                $x = $matrix2[$matrix2Rows - 1];
                for ($i = 0; $i < $matrix1Rows; ++$i) {
                    $matrix2[$i] = $x;
                }
            }
        }

        if (($matrix1Columns < $matrix2Columns) || ($matrix1Rows < $matrix2Rows)) {
            if ($matrix1Columns < $matrix2Columns) {
                for ($i = 0; $i < $matrix1Rows; ++$i) {
                    $x = $matrix1[$i][$matrix1Columns - 1];
                    for ($j = $matrix1Columns; $j < $matrix2Columns; ++$j) {
                        $matrix1[$i][$j] = $x;
                    }
                }
            }
            if ($matrix1Rows < $matrix2Rows) {
                $x = $matrix1[$matrix1Rows - 1];
                for ($i = 0; $i < $matrix2Rows; ++$i) {
                    $matrix1[$i] = $x;
                }
            }
        }
    }

    /**
     * Format details of an operand for display in the log (based on operand type).
     *
     * @param mixed $value First matrix operand
     */
    private function showValue(mixed $value): mixed
    {
        if ($this->debugLog->getWriteDebugLog()) {
            $testArray = Functions::flattenArray($value);
            if (count($testArray) == 1) {
                $value = array_pop($testArray);
            }

            if (is_array($value)) {
                $returnMatrix = [];
                $pad = $rpad = ', ';
                foreach ($value as $row) {
                    if (is_array($row)) {
                        $returnMatrix[] = implode($pad, array_map([$this, 'showValue'], $row));
                        $rpad = '; ';
                    } else {
                        $returnMatrix[] = $this->showValue($row);
                    }
                }

                return '{ ' . implode($rpad, $returnMatrix) . ' }';
            } elseif (is_string($value) && (trim($value, self::FORMULA_STRING_QUOTE) == $value)) {
                return self::FORMULA_STRING_QUOTE . $value . self::FORMULA_STRING_QUOTE;
            } elseif (is_bool($value)) {
                return ($value) ? self::$localeBoolean['TRUE'] : self::$localeBoolean['FALSE'];
            } elseif ($value === null) {
                return self::$localeBoolean['NULL'];
            }
        }

        return Functions::flattenSingleValue($value);
    }

    /**
     * Format type and details of an operand for display in the log (based on operand type).
     *
     * @param mixed $value First matrix operand
     */
    private function showTypeDetails(mixed $value): ?string
    {
        if ($this->debugLog->getWriteDebugLog()) {
            $testArray = Functions::flattenArray($value);
            if (count($testArray) == 1) {
                $value = array_pop($testArray);
            }

            if ($value === null) {
                return 'a NULL value';
            } elseif (is_float($value)) {
                $typeString = 'a floating point number';
            } elseif (is_int($value)) {
                $typeString = 'an integer number';
            } elseif (is_bool($value)) {
                $typeString = 'a boolean';
            } elseif (is_array($value)) {
                $typeString = 'a matrix';
            } else {
                if ($value == '') {
                    return 'an empty string';
                } elseif ($value[0] == '#') {
                    return 'a ' . $value . ' error';
                }
                $typeString = 'a string';
            }

            return $typeString . ' with a value of ' . $this->showValue($value);
        }

        return null;
    }

    /**
     * @return false|string False indicates an error
     */
    private function convertMatrixReferences(string $formula): false|string
    {
        static $matrixReplaceFrom = [self::FORMULA_OPEN_MATRIX_BRACE, ';', self::FORMULA_CLOSE_MATRIX_BRACE];
        static $matrixReplaceTo = ['MKMATRIX(MKMATRIX(', '),MKMATRIX(', '))'];

        //    Convert any Excel matrix references to the MKMATRIX() function
        if (str_contains($formula, self::FORMULA_OPEN_MATRIX_BRACE)) {
            //    If there is the possibility of braces within a quoted string, then we don't treat those as matrix indicators
            if (str_contains($formula, self::FORMULA_STRING_QUOTE)) {
                //    So instead we skip replacing in any quoted strings by only replacing in every other array element after we've exploded
                //        the formula
                $temp = explode(self::FORMULA_STRING_QUOTE, $formula);
                //    Open and Closed counts used for trapping mismatched braces in the formula
                $openCount = $closeCount = 0;
                $notWithinQuotes = false;
                foreach ($temp as &$value) {
                    //    Only count/replace in alternating array entries
                    $notWithinQuotes = $notWithinQuotes === false;
                    if ($notWithinQuotes === true) {
                        $openCount += substr_count($value, self::FORMULA_OPEN_MATRIX_BRACE);
                        $closeCount += substr_count($value, self::FORMULA_CLOSE_MATRIX_BRACE);
                        $value = str_replace($matrixReplaceFrom, $matrixReplaceTo, $value);
                    }
                }
                unset($value);
                //    Then rebuild the formula string
                $formula = implode(self::FORMULA_STRING_QUOTE, $temp);
            } else {
                //    If there's no quoted strings, then we do a simple count/replace
                $openCount = substr_count($formula, self::FORMULA_OPEN_MATRIX_BRACE);
                $closeCount = substr_count($formula, self::FORMULA_CLOSE_MATRIX_BRACE);
                $formula = str_replace($matrixReplaceFrom, $matrixReplaceTo, $formula);
            }
            //    Trap for mismatched braces and trigger an appropriate error
            if ($openCount < $closeCount) {
                if ($openCount > 0) {
                    return $this->raiseFormulaError("Formula Error: Mismatched matrix braces '}'");
                }

                return $this->raiseFormulaError("Formula Error: Unexpected '}' encountered");
            } elseif ($openCount > $closeCount) {
                if ($closeCount > 0) {
                    return $this->raiseFormulaError("Formula Error: Mismatched matrix braces '{'");
                }

                return $this->raiseFormulaError("Formula Error: Unexpected '{' encountered");
            }
        }

        return $formula;
    }

    /**
     *    Binary Operators.
     *    These operators always work on two values.
     *    Array key is the operator, the value indicates whether this is a left or right associative operator.
     */
    private static array $operatorAssociativity = [
        '^' => 0, //    Exponentiation
        '*' => 0, '/' => 0, //    Multiplication and Division
        '+' => 0, '-' => 0, //    Addition and Subtraction
        '&' => 0, //    Concatenation
        '∪' => 0, '∩' => 0, ':' => 0, //    Union, Intersect and Range
        '>' => 0, '<' => 0, '=' => 0, '>=' => 0, '<=' => 0, '<>' => 0, //    Comparison
    ];

    /**
     *    Comparison (Boolean) Operators.
     *    These operators work on two values, but always return a boolean result.
     */
    private static array $comparisonOperators = ['>' => true, '<' => true, '=' => true, '>=' => true, '<=' => true, '<>' => true];

    /**
     *    Operator Precedence.
     *    This list includes all valid operators, whether binary (including boolean) or unary (such as %).
     *    Array key is the operator, the value is its precedence.
     */
    private static array $operatorPrecedence = [
        ':' => 9, //    Range
        '∩' => 8, //    Intersect
        '∪' => 7, //    Union
        '~' => 6, //    Negation
        '%' => 5, //    Percentage
        '^' => 4, //    Exponentiation
        '*' => 3, '/' => 3, //    Multiplication and Division
        '+' => 2, '-' => 2, //    Addition and Subtraction
        '&' => 1, //    Concatenation
        '>' => 0, '<' => 0, '=' => 0, '>=' => 0, '<=' => 0, '<>' => 0, //    Comparison
    ];

    //include 'Calculationparts2.php';
}	
?>	