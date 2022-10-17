	    <!-- Button to trigger modal -->
	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">New Shelve</button>
	<br>
	<br>
	<br>
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
	<h3 id="myModalLabel">Add</h3>
	</div>
	<form method="post" action="./_custom/shelves/upload.php"  enctype="multipart/form-data">
		<div class="modal-body">
			<table class="table1">
				<tr>
					<td><label style="color:#3a87ad; font-size:18px;">Shelve Name</label></td>
					<td width="30"></td>
					<td><input type="text" name="first_name" placeholder="Shelve Name" required /></td>
				</tr>
				<tr>
					<td><label style="color:#3a87ad; font-size:18px;">Description</label></td>
					<td width="30"></td>
					<td><input type="text" name="last_name" placeholder="Description" required /></td>
				</tr>
				<tr>
					<td><label style="color:#3a87ad; font-size:18px;">Select shelve image</label></td>
					<td width="30"></td>
					<td><input type="file" name="image"></td>
				</tr>
			</table>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button type="submit" name="Submit" class="btn btn-primary">Upload</button>
		</div>
	</form>
</div>			