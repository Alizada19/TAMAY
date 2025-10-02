<!-- Create a container for the AG-Grid table -->
<div id="myGrid" class="ag-theme-alpine" style="height: 500px; width: 100%;margin-top:20px;"></div>
<script>

if (typeof gridApi=='undefined') {
       
	let gridApi=null;
	// Row Data Interface

	// Grid API: Access to Grid API methods
		// Grid Options: Contains all of the grid configurations
		const rowData = <?php echo $rows; ?>;
		const gridOptions = {
		  // Data to be displayed
		  rowData:rowData,
		  // Columns to be displayed (Should match rowData properties)
		  columnDefs: [
			{ field: "Id" },
			{ field: "name" },
			{ field: "lname", editable: true},
			
		  ],
		  defaultColDef: {
			flex: 1,
		  },
		};
					
	// Create Grid: Create new grid within the #myGrid div, using the Grid Options object
	gridApi = agGrid.createGrid(document.querySelector("#myGrid"), gridOptions);
}
else
{
	 console.log("Grid already exists, destroying it first...");
     destroyGrid(); // Destroy existing grid before creating a new one
}	
// Function to destroy the grid if it exists
function destroyGrid() {
	if (gridApi) {
		console.log("Destroying the existing grid...");
		gridApi.destroy(); // Destroy the grid instance
		gridApi = null; // Reset gridApi
		console.log("Grid destroyed.");
	} else {
		console.log("No grid to destroy.");
	}
}
</script>