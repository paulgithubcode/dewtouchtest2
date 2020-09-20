<div class="alert  ">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>

<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>


<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>



<div class="alert alert-success">
    <button class="close" data-dismiss="alert"></button>
    The table you start with</div>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <th>
            <span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
                                        <i class="icon-plus"></i></span>
        </th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Unit Price</th>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td><textarea name="data[1][description]" class="m-wrap  description required" rows="2" ></textarea></td>
            <td><input name="data[1][quantity]" class=""></td>
            <td><input name="data[1][unit_price]"  class=""></td>
        </tr>
    </tbody>
</table>


<p></p>
    <div class="alert alert-info ">
    <button class="close" data-dismiss="alert"></button>
    Video Instruction</div>

<p style="text-align:left;">
<video width="78%"   controls>
  <source src="<?php echo Router::url("/video/q3_2.mov") ?>">
Your browser does not support the video tag.
</video>
</p>

<?php $this->start('script_own');?>
<script>
    var tb_number_row = 2;
$(document).ready(function(){

	$("#add_item_button").click(function(){

	    $("table tr td").find('input, textarea').each(function(){
            val = $(this).val().replace(/\r\n|\r|\n/g,"<br />");
            elName = $(this)[0].tagName.toLowerCase();
            name = $(this).prop('name');

            numberRow = 0;
            var matches = name.match(/\[(.*?)\]/);
            if (matches) {
                var numberRow = matches[1];
            }
            $(this).parent()
                .attr("data-val",val)
                .attr("data-elName",elName)
                .attr("data-name",name)
                .attr("data-numberRow",numberRow)
                .html(val);
        });

<?php /*		alert("suppose to add a new row"); */ ?>

        var row_append = '<tr><td></td>' +
            '<td><textarea name="data['+tb_number_row+'][description]" class="m-wrap  description required" rows="2" ></textarea></td>' +
            '<td><input name="data['+tb_number_row+'][quantity]" class=""></td>' +
            '<td><input name="data['+tb_number_row+'][unit_price]"  class=""></td></tr>';
        $('table > tbody:last-child').append(row_append);
        tb_number_row = tb_number_row + 1;
    });

    $(document).on('keypress','table tr td input',function(event){
        name = $(this).attr('name');
        field_name = '';
        var matches = name.match(/\[(.*?)\]\[(.*?)\]/);
        if (matches) {
            var field_name = matches[2];
            if(field_name == 'quantity'){
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57) || $(this).val() == "0") {
                    event.preventDefault();
                }
            }else if(field_name == 'unit_price'){
                $(this).val($(this).val().replace(/[^0-9\.]/g,''));
                if (((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57))
                    || ($(this).val() == "0" && event.which != 46)) {
                    event.preventDefault();
                }
                if ($(this).val().indexOf('.') > -1)
                {
                    if($(this).val().split('.')[1].length > 1){
                        event.preventDefault();
                    }
                }

            };
        }

    });

	$(document).on('click','td',function(){
	    if($(this).attr('data-name') != undefined){
            data_val = $(this).attr('data-val').replace(/<br *\/?>/gi, '\r\n');
            data_elName = $(this).attr('data-elName');
            data_name = $(this).attr('data-name');
            data_numberRow = $(this).attr('data-numberRow');

            $(this).removeAttr('data-val')
                .removeAttr('data-elName')
                .removeAttr('data-name')
                .removeAttr('data-numberRow');

            if(data_elName == 'textarea'){
                $(this).html($('<'+data_elName+'>', { 'name':data_name, 'class':"m-wrap  description required", 'rows':2, 'value':data_val}));
            }else if(data_elName == 'input'){
                $(this).html($('<'+data_elName+'>', { 'name':data_name, 'class':"", 'value':data_val}));
            }
        }
    });

	
});
</script>
<?php $this->end();?>

