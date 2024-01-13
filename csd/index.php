<?php

session_start();

$title = 'CSD';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php';

// Get the dialog_panels from database sql
$sql = "SELECT * FROM `dialog_panels`";
$dialog_panels = $db->select($sql);

?>

<div class="container mx-auto mt-8">
    <div class="grid grid-cols-1 p-2 sm:p-0 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">

        <?php foreach ($dialog_panels as $dialog_panel) :
            // Get de dialogs from database sql
            $sql = "SELECT * FROM `dialogs` WHERE `department` = '$dialog_panel[department]' AND `panel` = '$dialog_panel[uuid]' AND `is_root` = 1";
            $dialogs = $db->select($sql);

            ?>

            <div class="bg-white rounded-lg shadow-md m-5">
                <div class="bg-primary">
                    <h2 class="text-2xl p-2 text-white font-semibold"><?= $dialog_panel['name'] ?></h2>
                </div>
                <?php foreach ($dialogs as $dialog) : ?>
                    <a href="/csd/dialog.php?dialog=<?= $dialog['uuid'] ?>" class="text-xl font-semibold text-gray-700">
                        <div class="hover:bg-secondary">
                            <div class="p-6">
                                <?= $dialog['title'] ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
