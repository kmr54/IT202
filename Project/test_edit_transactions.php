
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
    $amount = $_POST["amount"];
    $source = $_POST["act_src_id"];
    if ($source <= 0) {
        $source = null;
    }
    $dest = $_POST["act_dest_id"];
    $type = $_POST["action_type"];
    $memo = $_POST["memo"];
    $total = $_POST["expected_total"];
    $user = get_user_id();
    $db = getDB();
    if (isset($id)) {
        $stmt = $db->prepare("UPDATE Transactions set amount=:amount, act_src_id=:source, act_dest_id=:dest, action_type=:type, memo=:memo, total=:total where id=:id");
        $r = $stmt->execute([
            ":amount" => $amount,
            ":source" => $source,
	    ":dest" => $dest,
            ":type" => $type,
            ":memo" => $memo,
            ":total" => $total,
            ":id" => $id
        ]);
        if ($r) {
            flash("Updated successfully with id: " . $id);
        }
        else {
            $e = $stmt->errorInfo();
            flash("Error updating: " . var_export($e, true));
        }
    }
    else {
        flash("ID isn't set, we need an ID in order to update");
    }
}
?>
<?php
//fetching
$result = [];
if (isset($id)) {
    $id = $_GET["id"];
    $db = getDB();
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
        <label>Account</label>
        <select name="act_src_id" value="<?php echo $result["act_src_id"];?>" >
            <option value="-1">None</option>
            <?php foreach ($accounts as $account): ?>
                <option value="<?php safer_echo($account["id"]); ?>" <?php echo ($result["act_src_id"] == $account["id"] ? 'selected="selected"' : ''); ?>
                ><?php safer_echo($account["name"]); ?></option>
            <?php endforeach; ?>
        </select>
///////////////////ACCOUNT DESTINATION ID////////////
        <label>Action Type</label>
        <input type="action_type" min="1" name="action_type"/>
	<label>Memo</label>
        <input type="text" name="memo"/>
        <input type="submit" name="save" value="Update"/>
    </form>


<?php require(__DIR__ . "/partials/flash.php");
