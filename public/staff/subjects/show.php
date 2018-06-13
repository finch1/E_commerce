<?php require_once('../../../private/initialize.php'); ?>

<?php
require_login();
    $id = $_GET['id'] ?? '1'; //like ternary operator

    $subject = find_subject_by_id($id);

?>

<?php $page_title = 'Show Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php');?>

<div id="content">
    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php');?>">&laquo; Back to List</a>

    <div class="subjects show">
        <h1>Subject: <?php echo h($subject['menu_name']); ?></h1>

        <div class="attributes">
            <dl>
                <dt>Menu Name</dt>
                <dd><?php echo h($subject['menu_name']);?></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd><?php echo h($subject['position']);?></dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd><?php echo $subject['visible'] == '1' ? 'true' : 'false'; ?></dd>
            </dl>
        </div>
    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>


<!--<a href="show.php?name=-->
<?php //echo u('John Doe'); ?>
<!--">Link</a><br/>-->
