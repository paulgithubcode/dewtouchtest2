<div class="row-fluid">
    <div class="alert alert-info">
        <h3>Migration Data</h3>
    </div>

    <hr />

    <div class="alert">
        <h3>Import Form</h3>
    </div>
    <?php
    echo $this->Form->create('Transaction', array('type' => 'file'));
    echo $this->Form->input('file', array('label' => 'File Upload', 'type' => 'file'));
    echo $this->Form->submit('Upload', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    ?>

    <hr />

    <div class="alert alert-success">
        <h3>Data Imported Member</h3>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>No</th>
            <th>Name</th>
            <th>Company</th>
            <th>Valid</th>
            <th>Created</th>
            <th>Modified</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($members as $member) :
            ?>
            <tr>
                <td><?php echo $member['Member']['id']; ?>
                <td><?php echo $member['Member']['type']; ?>
                <td><?php echo $member['Member']['no']; ?>
                <td><?php echo $member['Member']['name']; ?>
                <td><?php echo $member['Member']['company']; ?>
                <td><?php echo $member['Member']['valid']; ?>
                <td><?php echo $member['Member']['created']; ?>
                <td><?php echo $member['Member']['modified']; ?>
            </tr>
            <?php
        endforeach;
        ?>
        </tbody>
    </table>


    <hr />

    <div class="alert alert-success">
        <h3>Data Imported Transaction</h3>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Member ID</th>
            <th>Member Name</th>
            <th>Member PayType</th>
            <th>Member Company</th>
            <th>Date</th>
            <th>Year</th>
            <th>Month</th>
            <th>Ref No</th>
            <th>Receipt No</th>
            <th>Payment Method</th>
            <th>Batch No</th>
            <th>Chequeu No</th>
            <th>Payment Type</th>
            <th>Renewal Year</th>
            <th>Remarks</th>
            <th>Subtotal</th>
            <th>Tax</th>
            <th>Total</th>
            <th>Valid</th>
            <th>Created</th>
            <th>Modified</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($transactions as $transaction) :
            ?>
            <tr>
                <td><?php echo $transaction['Transaction']['id']; ?>
                <td><?php echo $transaction['Transaction']['member_id']; ?>
                <td><?php echo $transaction['Transaction']['member_name']; ?>
                <td><?php echo $transaction['Transaction']['member_paytype']; ?>
                <td><?php echo $transaction['Transaction']['member_company']; ?>
                <td><?php echo $transaction['Transaction']['date']; ?>
                <td><?php echo $transaction['Transaction']['year']; ?>
                <td><?php echo $transaction['Transaction']['month']; ?>
                <td><?php echo $transaction['Transaction']['ref_no']; ?>
                <td><?php echo $transaction['Transaction']['receipt_no']; ?>
                <td><?php echo $transaction['Transaction']['payment_method']; ?>
                <td><?php echo $transaction['Transaction']['batch_no']; ?>
                <td><?php echo $transaction['Transaction']['cheque_no']; ?>
                <td><?php echo $transaction['Transaction']['payment_type']; ?>
                <td><?php echo $transaction['Transaction']['renewal_year']; ?>
                <td><?php echo $transaction['Transaction']['remarks']; ?>
                <td><?php echo $transaction['Transaction']['subtotal']; ?>
                <td><?php echo $transaction['Transaction']['tax']; ?>
                <td><?php echo $transaction['Transaction']['total']; ?>
                <td><?php echo $transaction['Transaction']['valid']; ?>
                <td><?php echo $transaction['Transaction']['created']; ?>
                <td><?php echo $transaction['Transaction']['modified']; ?>
            </tr>
            <?php
        endforeach;
        ?>
        </tbody>
    </table>


    <hr />

    <div class="alert alert-success">
        <h3>Data Imported Transaction Items</h3>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Transaction ID</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>UOM</th>
            <th>Sum</th>
            <th>Valid</th>
            <th>Created</th>
            <th>Modified</th>
            <th>Table</th>
            <th>Table ID</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($transaction_items as $transaction_item) :
            ?>
            <tr>
                <td><?php echo $transaction_item['TransactionItem']['id']; ?>
                <td><?php echo $transaction_item['TransactionItem']['transaction_id']; ?>
                <td><?php echo $transaction_item['TransactionItem']['description']; ?>
                <td><?php echo $transaction_item['TransactionItem']['quantity']; ?>
                <td><?php echo $transaction_item['TransactionItem']['unit_price']; ?>
                <td><?php echo $transaction_item['TransactionItem']['uom']; ?>
                <td><?php echo $transaction_item['TransactionItem']['sum']; ?>
                <td><?php echo $transaction_item['TransactionItem']['valid']; ?>
                <td><?php echo $transaction_item['TransactionItem']['created']; ?>
                <td><?php echo $transaction_item['TransactionItem']['modified']; ?>
                <td><?php echo $transaction_item['TransactionItem']['table']; ?>
                <td><?php echo $transaction_item['TransactionItem']['table_id']; ?>
            </tr>
            <?php
        endforeach;
        ?>
        </tbody>
    </table>

</div>