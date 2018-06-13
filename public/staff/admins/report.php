<?php

require_once('../../../private/initialize.php');

require_login();

?>

<?php $page_title = 'Show Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>
    <div class="admins reporting">
        <h1>Admins</h1>


        <table class="list">
            <tr>
                <th>Sum of Users</a></th>
                <th>Sum of Orders</a></th>
                <th>Sum of Profit </a></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <td><?php echo h(last_insert_id()); ?></td>
                <td><?php echo h(total_orders()); ?></td>
                <td><?php echo h(total_profit()); ?></td>
            </tr>

        </table>
    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
