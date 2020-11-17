<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>

<?php
//fetching
$result = [];
if (isset($id)) {
    $id = $_GET["id"];
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM Transactions where id = :id");
    $r = $stmt->execute([":id" => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
//get eggs for dropdown
$db = getDB();
$stmt = $db->prepare("SELECT id,name from Accounts LIMIT 10");
$r = $stmt->execute();
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <h3>Create Transaction</h3>
    <form method="POST">
        <label>Account Source</label>
        <select name="act_src_id">
            <?php foreach ($accounts as $account): ?>
                <option value="<?php safer_echo($account["id"]); ?>" <?php echo ($result["act_src_id"] == $account["id"] ? 'selected="selected"' : ''); ?>
                ><?php safer_echo($account["account_number"]); ?></option>
            <?php endforeach;?>
        </select>
        <label>Account Destination</label>
        <select name="act_dest_id">
            <?php foreach ($accounts as $account): ?>
                <option value="<?php safer_echo($account["id"]); ?>" <?php echo ($result["act_dest_id"] == $account["id"] ? 'selected="selected"' : ''); ?>
                ><?php safer_echo($account["account_number"]); ?></option>
            <?php endforeach;?>
        </select>
        <label>Amount</label>
        <input type="number" name="amount" min="0" placeholder="0.00"/>
        <label>Action Type</label>
        <select name="action_type">
            <option value="Deposit">Deposit</option>
            <option value="Withdrawal">Withdrawal</option>
            <option value="Transfer">Transfer</option>
        </select>
        <label>Memo</label>
        <input type="text" name="memo"/>
        <input type="submit" name="save" value="Create"/>
    </form>

/*
<?php
//we'll put this at the top so both php block have access to it
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
?>
<?php
*/

<?php
if (isset($_POST["save"])) {
    //TODO add proper validation/checks
    $act_src_id = $_POST["act_src_id"];
    $act_dest_id = $_POST["act_dest_id"];
    $amount = $_POST["amount"];
    $action_type = $_POST["action_type"];
    $memo = $_POST["memo"];
    $user_id = get_user_id();

    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Transactions (act_src_id, act_dest_id, amount, action_type, memo, user_id) VALUES(:source, :dest, :amount,:action_type,:memo, :user)");
    $r = $stmt->execute([
        ":act_src_id" => $source,
        ":act_dest_id" => $dest,
        ":amount" => $amount,
        ":action_type" => $action_type,
	":memo" => $memo,
        ":user_id" => $user
    ]);

    if ($r) {
        flash("Created successfully with id: " . $db->lastInsertId());
    }
    else {
        $e = $stmt->errorInfo();
        flash("Error creating: " . var_export($e, true));
    }
}
?>
<?php require(__DIR__ . "/partials/flash.php");
