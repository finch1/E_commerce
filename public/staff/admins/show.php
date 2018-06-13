<?php

    require_once('../../../private/initialize.php');

    require_login();

    $id = $_GET['id'] ?? '1'; // PHP > 7.0
    $admin = find_admin_by_id($id);

?>

<?php $page_title = 'Show Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin show">

    <h1>Admin: <?php echo h($admin['username']); ?></h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/admins/edit.php?id=' . h(u($admin['_id']))); ?>">Edit</a>
      <a class="action" href="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($admin['_id']))); ?>">Delete</a>
    </div>

    <div class="attributes">
        <dl>
            <dt>Id</dt>
            <dd><?php echo h($admin['_id']); ?></dd>
        </dl>
        <dl>
            <dt>isActive</dt>
            <dd><?php echo h($admin['isActive']); ?></dd>
        </dl>
        <dl>
            <dt>First name</dt>
            <dd><?php echo h($admin['name']); ?></dd>
        </dl>
        <dl>
            <dt>Last name</dt>
            <dd><?php echo h($admin['surname']); ?></dd>
        </dl>
        <dl>
            <dt>Username</dt>
            <dd><?php echo h($admin['username']); ?></dd>
        </dl>
        <dl>
            <dt>Age</dt>
            <dd><?php echo h($admin['age']); ?></dd>
        </dl>
        <dl>
            <dt>Email</dt>
            <dd><?php echo h($admin['email']); ?></dd>
        </dl>
        <dl>
            <dt>Phone</dt>
            <dd><?php echo h($admin['phone']); ?></dd>
        </dl>
        <dl>
            <dt>Address</dt>
            <dd><?php echo h($admin['address']); ?></dd>
        </dl>
        <dl>
            <dt>Registered On:</dt>
            <dd><?php echo h($admin['registered']); ?></dd>
        </dl>
        <dl>
            <dt>Admin</dt>
            <dd><?php echo h($admin['admin']);?></dd>
        </dl>
        <dl>
            <dt>addUser</dt>
            <dd><?php $temp = MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($admin ['privileges'])) ; $result = json_decode ($temp, true); echo $result[0]['addUser'];?></dd>
        </dl>
        <dl>
            <dt>editUser</dt>
            <dd><?php $temp = MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($admin ['privileges'])) ; $result = json_decode ($temp, true); echo $result[0]['editUser'];?></dd>
        </dl>
        <dl>
            <dt>delUser</dt>
            <dd><?php $temp = MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($admin ['privileges'])) ; $result = json_decode ($temp, true); echo $result[0]['delUser'];?></dd>
        </dl>
        <dl>
            <dt>ORDERS</dt>
            <dd></dd>
        </dl>
        <?php
        $temp = MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($admin ['orders'])) ; $result = json_decode ($temp, true);
        foreach ($result as $i => $values) {?>
            <dl>
                <dt>invoiceNumber</dt>
                <dd><?php echo $result[$i]['invoiceNumber'];?></dd>
            </dl>
            <dl>
                <dt>date</dt>
                <dd><?php echo $result[$i]['date'];?></dd>
            </dl>
            <dl>
                <dt>total</dt>
                <dd><?php echo $result[$i]['total'];?></dd>
            </dl>
            <dl>
                <dt>shipping</dt>
                <dd><?php echo $result[$i]['shipping'];?></dd>
            </dl>

            <?php
        }?>
        <dl>
            <dt>CART</dt>
            <dd></dd>
        </dl>
        <?php
          $temp = MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($admin ['cart'])) ; $result = json_decode ($temp, true);
            foreach ($result as $i => $values) {?>
                    <dl>
                    <dt>item</dt>
                        <dd><?php echo $result[$i]['item'];?></dd>
                    </dl>
                    <dl>
                        <dt>pkgId</dt>
                        <dd><?php echo $result[$i]['pkgId'];?></dd>
                    </dl>
                    <dl>
                        <dt>qty</dt>
                        <dd><?php echo $result[$i]['qty'];?></dd>
                    </dl>

            <?php
            }?>


    </div>

  </div>

</div>
