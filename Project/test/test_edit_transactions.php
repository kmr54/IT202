<<<<<<< HEAD
<<<<<<< HEAD
=======

>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
=======
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
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
//saving
if (isset($_POST["save"])) {
    //TODO add proper validation/checks
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
    $amount = $_POST["amount"];
    $source = $_POST["act_src_id"];
    $dest = $_POST["act_dest_id"];
    $type = $_POST["action_type"];
    $memo = $_POST["memo"];
<<<<<<< HEAD
=======
    $act_src_id = $_POST["act_src_id"];
    $act_dest_id = $_POST["act_dest_id"];
    $amount = $_POST["amount"];
    $action_type = $_POST["action_type"];
    $memo = $_POST["memo"];
    $user_id = get_user_id();
    //$total = $_POST["expected_total"];
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
=======
    $user_id = get_user_id();
    //$total = $_POST["expected_total"];
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
    $db = getDB();
    if (isset($id)) {
        $stmt = $db->prepare("UPDATE Transactions set amount=:amount, act_src_id=:source, act_dest_id=:dest, action_type=:type, memo=:memo where id=:id");
        $r = $stmt->execute([
            ":amount" => $amount,
<<<<<<< HEAD
<<<<<<< HEAD
            ":act_src_id" => $source,
	    ":act_dest_id" => $dest,
            ":action_type" => $type,
=======
            ":source" => $source,
	    ":dest" => $dest,
            ":type" => $type,
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
=======
            ":act_src_id" => $source,
	    ":act_dest_id" => $dest,
            ":action_type" => $type,
            ":source" => $source,
	    ":dest" => $dest,
            ":type" => $type,
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
            ":memo" => $memo,
            ":id" => $id
        ]);
        if ($r) {
            flash("Updated successfully with id: " . $id);
        }
        else {
            $e = $stmt->errorInfo();
            flash("Error updating: " . var_export($e, true));
        }
<<<<<<< HEAD
<<<<<<< HEAD
=======
    }
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
=======
    }
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
    else {
        flash("ID isn't set, we need an ID in order to update");
    }
}
?>
<<<<<<< HEAD
<<<<<<< HEAD

=======
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
=======

>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
<?php
//fetching
$result = [];
if (isset($id)) {
    $id = $_GET["id"];
    $db = getDB();
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
    $stmt = $db->prepare("SELECT * FROM Transactions where id = :id");
    $r = $stmt->execute([":id" => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}

$db = getDB();
$stmt = $db->prepare("SELECT id,name from Accounts LIMIT 10");
$r = $stmt->execute();
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
    <h3>Edit Transaction</h3>
    <form method="POST">
	<label>Amount</label>
        <input type="number" name="amount" min="0" placeholder="0.00"/>
        <label>Account Source</label>
        <select name="act_src_id">
            <?php foreach ($accounts as $account): ?>
                <option value="<?php safer_echo($account["id"]); ?>"
                ><?php safer_echo($account["account_number"]); ?></option>
            <?php endforeach;?>
        </select>
        <label>Account Destination</label>
        <select name="act_dest_id">
            <?php foreach ($accounts as $account): ?>
                <option value="<?php safer_echo($account["id"]); ?>"
                ><?php safer_echo($account["account_number"]); ?></option>
            <?php endforeach;?>
        </select>
        <label>Action Type</label>
        <select name="action_type">
            <option value="deposit">Deposit</option>
            <option value="withdraw">Withdraw</option>
            <option value="transfer">Transfer</option>
        </select>
        <label>Memo</label>
        <input type="text" name="memo"/>
        <input type="submit" name="save" value="Create"/>
<<<<<<< HEAD
=======
=======
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
    $stmt = $db->prepare("SELECT * Transactions where id = :id");
    $r = $stmt->execute([":id" => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
$db = getDB();
$stmt = $db->prepare("SELECT id,name from Accounts LIMIT 10");
$r = $stmt->execute();
$eggs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <h3>Edit Transactions</h3>
    <form method="POST">
        <label>Amount</label>
        <input name="amount" placeholder="Amount" value="<?php echo $result["amount"]; ?>"/>
        <label>Account Source</label>
        <select name="act_src_id" value="<?php echo $result["act_src_id"];?>" >
            <option value="-1">None</option>
            <?php foreach ($accounts as $account): ?>
                <option value="<?php safer_echo($account["id"]); ?>" <?php echo ($result["act_src_id"] == $account["id"] ? 'selected="selected"' : ''); ?>
                ><?php safer_echo($account["name"]); ?></option>
            <?php endforeach; ?>
        </select>
	<label>Account Destination</label>
        <select name="act_dest_id" value="<?php echo $result["act_dest_id"];?>" >
            <option value="-1">None</option>
            <?php foreach ($accounts as $account): ?>
                <option value="<?php safer_echo($account["id"]); ?>" <?php echo ($result["act_dest_id"] == $account["id"] ? 'selected="selected"' : ''); ?>
                ><?php safer_echo($account["name"]); ?></option>
            <?php endforeach; ?>
        </select>
	<label>Action Type</label>
        <select name="type">
                <option value="0">Deposit</option>
                <option value="1">Withdrawal</option>
                <option value="2">Transfer</option>
        </select>        
	<label>Memo</label>
        <input type="text" name="memo"/>
        <input type="submit" name="save" value="Update"/>
<<<<<<< HEAD
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
=======
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
    </form>


<?php require(__DIR__ . "/partials/flash.php");
<<<<<<< HEAD
<<<<<<< HEAD

=======
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
=======
>>>>>>> 17f21803f16709531dc8e70508ea66ad9fdd13d0
