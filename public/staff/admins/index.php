<?php require_once('../../../private/initialize.php');
    require_login();

    $id = $_GET['id'] ?? 'id'; // PHP > 7.0

    $admin_set = find_all_admins($id);
?>

<?php $page_title = 'Admins'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

    <div id="content">
      <div class="admins listing">
        <h1>Admins</h1>

        <div class="actions">
            <a class="action" href="<?php echo url_for('/staff/admins/new.php');?>">create new admin</a>
          <a class="action" href="<?php echo url_for('/staff/admins/new.php');?>">Backup DataBase</a>
            <a class="action" href="<?php echo url_for('/staff/admins/report.php');?>">Generate Report</a>
        </div>

        <table class="list">
          <tr>
            <th><a class="action" href="<?php echo url_for('/staff/admins/index.php?id=' . h(u('_id'))); ?>">ID</a></th>
            <th><a class="action" href="<?php echo url_for('/staff/admins/index.php?id=' . h(u('name'))); ?>">First</a></th>
            <th><a class="action" href="<?php echo url_for('/staff/admins/index.php?id=' . h(u('surname'))); ?>">Last</a></th>
            <th><a class="action" href="<?php echo url_for('/staff/admins/index.php?id=' . h(u('email'))); ?>">Email</a></th>
            <th><a class="action" href="<?php echo url_for('/staff/admins/index.php?id=' . h(u('username'))); ?>">Username</a></th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
          </tr>

        <?php foreach($admin_set as $document){?>
            <tr>
                <td><?php echo h($document['_id']); ?></td>
                <td><?php echo h($document['name']); ?></td>
                <td><?php echo h($document['surname']); ?></td>
                <td><?php echo h($document['email']); ?></td>
                <td><?php echo h($document['username']); ?></td>
                <td><a class="action" href="<?php echo url_for('/staff/admins/show.php?id=' . h(u($document['_id']))); ?>">View</a></td>
                <td><a class="action" href="<?php echo url_for('/staff/admins/edit.php?id=' . h(u($document['_id']))); ?>">Edit</a></td>
                <td><a class="action" href="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($document['_id']))); ?>">Delete</a></td>
            </tr>
        <?php } ?>
        </table>

        <?php
          //mysqli_free_result($admin_set);
        ?>
      </div>

    </div>

    <?php include(SHARED_PATH . '/staff_footer.php'); ?>
