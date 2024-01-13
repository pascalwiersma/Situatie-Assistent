<?php

session_start();

$title = 'CSD';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php';

$dialogId = $_GET['dialog'];

// Get the dialog_panels from the database SQL
$sql = "SELECT * FROM `dialogs` WHERE `uuid` = '$dialogId'";
$dialogs = $db->select($sql);

?>

<div class="container mx-auto mt-8 p-5">
    <div class="grid grid-cols-1">

        <?php foreach ($dialogs as $dialog) :
            // Get the buttons of the dialog
            $sql = "SELECT * FROM `dialogs` WHERE `previous_dialog`
            LIKE '%$dialogId%'";
            $nextDialogs = $db->select($sql);

            $nextDialogs_array = array();
            foreach ($nextDialogs as $nextDialog) {
                $nextDialogs_array[$nextDialog['uuid']] = $nextDialog['title'];
            }

            ?>
            <div class="bg-white rounded-lg shadow-md">
                <div class="bg-primary">
                    <h2 class="text-2xl p-2 text-white font-semibold text-center">
                        <?php echo $dialog['title'] ?>
                    </h2>
                </div>
                <div>
                    <div class="p-6 text-center">
                        <?php echo $dialog['qa']; ?>
                    </div>
                </div>
            </div>

            <!-- Buttons  -->
            <div class="flex justify-center container">
                <div class="mt-4">
                    <?php if (!empty($nextDialogs_array)) : ?>
                        <?php foreach ($nextDialogs_array as $key => $nextDialog) : ?>
                            <a href="/csd/dialog.php?dialog=<?= $key ?>" class="bg-primary hover:bg-blue-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <?= $nextDialog ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif ?>

                </div>
            </div>

        <?php endforeach; ?>

        <!-- Back button -->
        <div class="flex justify-center container">
            <div class="mt-4">
                <button onclick="goBack()" class="bg-tertiary hover:bg-primary text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    Terug naar vorige situatie
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
