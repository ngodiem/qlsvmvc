<?php require "layout/header.php" ?>
<h1>Danh sách Môn Học</h1>
<a href="index.php?c=subject&a=add" class="btn btn-info">Add</a>
<a href="index.php?c=subject&a=export" class="btn btn-success">Export</a>
<form action="index.php" method="GET">
	<label class="form-inline justify-content-end">Tìm kiếm: <input type="search" name="search" class="form-control" value="<?=!empty($search) ? $search: ""?>">
		<button class="btn btn-danger">Tìm</button>
	</label>
	<input type="hidden" name="c" value="subject">
</form>
<table class="table table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Mã MH</th>
			<th>Tên</th>
			<th>Số tín chỉ</th>
			<th colspan="2">Tùy Chọn</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$order = 0;
		foreach ($subjects as $subject): 
			$order++;
			?>
		<tr>
			<td><?=$order?></td>
			<td><?=$subject->id?></td>
			<td><?=$subject->name?></td>
			<td><?=$subject->number_of_credit?></td>
			<td><a href="index.php?c=subject&a=edit&id=<?=$subject->id?>">Sửa</a></td>
			<td><a class="delete" href="index.php?c=subject&a=delete&id=<?=$subject->id?>" type="subject">Xóa</a></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
<div>
	<span>Số lượng: <?=count($subjects)?></span>
</div>
<?php require "layout/footer.php" ?>