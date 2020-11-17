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
    $id = $_GET["id:];
}

/*
    <h3>Create Transaction</h3>
    <form method="POST">
        <label>Source Account</label placeholder="0">
            <select>
            <?php foreach($accounts as $index=>$row):?>
                <option name="act_src_id" value="<?php echo $index;?>">
                <?php echo $row["acct"];?>
                </option>
            <?php endforeach;?>
            </select>
        <label>Destination Account</label>
            <select>
            <?php foreach($accounts as $index=>$row):?>
                <option name="act_dest_id" value="<?php echo $index;?>">
                <?php echo $row["acct"];?>
                </option>
            <?php endforeach;?>
            </select>
        <label>Amount</label>
        <input type="number" name="amount"/>
        <label>Action Type</label>
        <select name="action_type">
            <option value="Deposit">Deposit</option>
            <option value="Withdrawal">Withdraw</option>
            <option value="Transfer">Transfer</option>
        </select>
        <label>Memo</label>
        <input type="text" name="memo"/>
        <input type="submit" name="save" value="Create"/>
    </form>
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
    $stmt = $db->prepare("INSERT INTO Transactions (act_src_id, act_dest_id, amount, action_type, memo, user_id) 
VALUES(:act_src_id, :act_dest_id, :action_type,:memo, :user_id)");
    $r = $stmt->execute([
        ":act_src_id" => $act_src_id,
        ":act_dest_id" => $act_dest_id,
        ":action_type" => $action_type,
        ":memo" => $memo,
	"amount" => $amount,
        ":user" => $user_id
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

if (isset($id)) {
    $id = $_GET["id"];
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM Transactions where id = :id");
    $r = $stmt->execute([":id" => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
//get accts for dropdown
$db = getDB();
$stmt = $db->prepare("SELECT id,name from Accounts LIMIT 10");
$r = $stmt->execute();
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<h3>Create Transaction</h3>
    <form method="POST">
        <label>Source Account</label placeholder="0">
            <select>
            <?php foreach($accounts as $index=>$row):?>
                <option name="act_src_id" value="<?php echo $index;?>">
                <?php echo $row["acct"];?>
                </option>
            <?php endforeach;?>
            </select>
        <label>Destination Account</label>
            <select>
            <?php foreach($accounts as $index=>$row):?>
                <option name="act_dest_id" value="<?php echo $index;?>">
                <?php echo $row["acct"];?>
                </option>
            <?php endforeach;?>
            </select>
        <label>Amount</label>
        <input type="number" name="amount"/>
        <label>Action Type</label>
        <select name="action_type">
            <option value="Deposit">Deposit</option>
            <option value="Withdrawal">Withdraw</option>
            <option value="Transfer">Transfer</option>
        </select>
        <label>Memo</label>
        <input type="text" name="memo"/>
        <input type="submit" name="save" value="Create"/>
    </form>




<?php require(__DIR__ . "/partials/flash.php");
