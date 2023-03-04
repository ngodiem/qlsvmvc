<?php require "layout/header.php" ?>
			<h1>Danh sách sinh viên</h1>
			<a href="index.php?a=add" class="btn btn-info">Add</a>
			<a href="index.php?&a=export" class="btn btn-success">Export</a>
			<a href="index.php?a=formImport" class="btn btn-warning">Import</a>
			<form action="index.php" method="GET">
				<label class="form-inline justify-content-end">Tìm kiếm: <input type="search" name="search" class="form-control" value="<?=!empty($search)? $search : ""?>">
				<button class="btn btn-danger">Tìm</button>
				</label>
			</form>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Mã SV</th>
						<th>Tên</th>
						<th>Ngày Sinh</th>
						<th>Giới Tính</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$order = 0;
					 ?>
					<?php foreach ($students as $student): {
						$order++;
						
					} ?>
					<tr>
						<td><?=$order?></td>
						<td><?=$student->id?></td>
						<td><?=$student->name?></td>
						<td><?=helper::formatVNDate($student->birthday)?></td>
						<td><?=$student->getGenderName()?></td>
						<td><a href="index.php?a=edit&id=<?=$student->id?>">Sửa</a></td>
						<td><a  class="delete" href="index.php?a=delete&id=<?=$student->id?>" type="student">Xóa</a></td>
					</tr>
				<?php endforeach ?>
					
				</tbody>
			</table>
			<div>
				<span>Số lượng: <?=count($students)?></span>
			</div>
<?php require "layout/footer.php" ?>