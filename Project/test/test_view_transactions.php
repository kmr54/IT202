<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
<?php
//we'll put this at the top so both php block have access to it
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
?>
<?php
//fetching
$result = [];
if (isset($id)) {
    $db = getDB();
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
    $stmt = $db->prepare("SELECT history.id, history.act_src_id, history.act_dest_id, history.amount,
	history.action_type, history.memo, Users.username, Accounts.account_number as account FROM Transactions as history JOIN Users on 
	history.user_id = Users.id LEFT JOIN Accounts Account on Account.id = history.act_src_id where history.id = :id");
    $r = $stmt->execute([":id" => $id]);
<<<<<<< HEAD
=======
    $stmt = $db->prepare("SELECT history.id, history.act_src_id, history.act_dest_id, history.amount,history.action_type, history.memo Users.username, Account.amount as account FROM Transactions as history JOIN Users on history.user_id = Users.id LEFT JOIN Accounts Account on Account.id = history.act_src_id where history.id = :id");
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
=======
    $stmt = $db->prepare("SELECT history.id, history.act_src_id, history.act_dest_id, history.amount,history.action_type, history.memo Users.username, Account.amount as account FROM Transactions as history JOIN Users on history.user_id = Users.id LEFT JOIN Accounts Account on Account.id = history.act_src_id where history.id = :id");
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
    $r = $stmt->execute([":id" => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        $e = $stmt->errorInfo();
        flash($e[2]);
    }
}
?>
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
<h3>Transactions</h3>
<?php if (isset($result) && !empty($result)): ?>
    <div class="card">
        <div class="card-body">
            <div>
                <p>View Transaction</p>
		<div>Amount: <?php safer_echo($result["amount"]); ?></div>
                <div>Account Source: <?php safer_echo($result["act_src_id"]); ?></div>
                <div>Account Destination: <?php safer_echo($result["act_dest_id"]); ?></div>
                <div>Action Type: <?php safer_echo($result["action_type"]); ?></div>
                <div>Memo: <?php safer_echo($result["memo"]); ?></div>
<<<<<<< HEAD
=======
=======
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
    <h3>View Transactions</h3>
<?php if (isset($result) && !empty($result)): ?>
    <div class="card">
        <div class="card-title">
            <?php safer_echo($result["amount"]); ?>
        </div>
        <div class="card-body">
            <div>
                <p>Stats</p>
		<div>Account Source: <?php safer_echo($r["act_src_id"]); ?></div>
		<div>Account Destination: <?php safer_echo($r["act_dest_id"]); ?></div>
                <div>Type: <?php safer_echo($result["action_type"]); ?></div>
		<div>Memo: <?php safer_echo($r["memo"]); ?></div>
                <div>Amount: <?php safer_echo($result["amount"]); ?></div>
<<<<<<< HEAD
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
=======
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
                <div>Owned by: <?php safer_echo($result["username"]); ?></div>
            </div>
        </div>
    </div>
<?php else: ?>
    <p>Error looking up id...</p>
<?php endif; ?>
<?php require(__DIR__ . "/partials/flash.php");
<<<<<<< HEAD
<<<<<<< HEAD

=======
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
=======
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
