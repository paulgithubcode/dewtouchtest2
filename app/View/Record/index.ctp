
<div class="row-fluid">
	<table class="table table-bordered" id="table_records">
		<thead>
			<tr>
				<th>ID</th>
				<th>NAME</th>	
			</tr>
		</thead>
		<tbody>
<?php /*			<?php foreach($records as $record):?>
			<tr>
				<td><?php echo $record['Record']['id']?></td>
				<td><?php echo $record['Record']['name']?></td>
			</tr>
			<?php endforeach;?> */ ?>
			<tr>
                <td colspan="4" class="dataTables_empty">Loading data from server...</td>
            </tr>
		</tbody>
	</table>
</div>
<?php $this->start('script_own')?>
<script>
$(document).ready(function(){
	$("#table_records").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "<?php echo $this->Html->Url(array('controller' => 'Record', 'action' => 'fetch')); ?>"
	});
})
</script>
<?php $this->end()?>