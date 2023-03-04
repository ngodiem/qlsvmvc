<?php require "layout/header.php" ?>
<h1>Danh sách sinh viên đăng ký môn học</h1>
<a href="index.php?c=register&a=add" class="btn btn-info">Add</a>
<a href="index.php?c=register&a=export" class="btn btn-success">Export</a>
<form action="index.php" method="GET">
	<label class="form-inline justify-content-end">Tìm kiếm: <input type="search" name="search" class="form-control" value="<?=!empty($search) ? $search: ""?>">
		<button class="btn btn-danger">Tìm</button>
	</label>
	<input type="hidden" name="c" value="register">
</form>
<table class="table table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Mã SV</th>
			<th>Tên SV</th>
			<th>Mã MH</th>
			<th>Tên MH</th>
			<th>Điểm</th>
			<th>Ngày</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$order = 0;
		foreach ($registers as $register): 
			$order++;
			?>
		<tr>
			<td><?=$order?></td>
			<td><?=$register->student_id?></td>
			<td><?=$register->student_name?></td>
			<td><?=$register->subject_id?></td>
			<td><?=$register->subject_name?></td>
			<td><?=$register->score?></td>
			<td><?=Helper::formatVNDate($register->created_at)?></td>
			<td><a href="index.php?c=register&a=edit&id=<?=$register->id?>">Sửa</a></td>
			<td><a class="delete" href="index.php?c=register&a=delete&id=<?=$register->id?>" type="register">Xóa</a></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
<div>
	<span>Số lượng: <?=count($registers)?></span>
</div>
<?php require "layout/footer.php" ?>