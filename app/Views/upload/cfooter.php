</div>
</div><!--end of main-->	
<script>
function makeCapital(value, id)
{
	myString = value.toUpperCase();
	document.getElementById(id).value = myString;
	document.getElementById(id).style="background-color:#b3d7ff87;font-size:30px;font-weight:bold";
}

//sidebar
function w3_open() {
  document.getElementById("main").style.marginLeft = "25%";
  document.getElementById("mySidebar").style.width = "25%";
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("openNav").style.display = 'none';
}
function w3_close() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("openNav").style.display = "inline-block";
}
</script>
</body>
</html>