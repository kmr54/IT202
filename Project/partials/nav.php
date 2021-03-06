<link rel="stylesheet" href="static/css/styles.css">
<?php
//we'll be including this on most/all pages so it's a good place to include anything else we want on those pages
require_once(__DIR__ . "/../lib/helpers.php");
?>

<header>
	<img src = "Images/piggybank.jpg" alt="Piggy Bank" height="80">
	<h1> <em class="shadow">Simple Bank</em> </h1>
</header>



<nav>
    <ul class="nav">
        <li><a href="home.php">Home</a></li>
        <?php if (!is_logged_in()): ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
        <?php if (has_role("Admin")): ?>
            <li><a href="/~kmr54/IT202/Project/test/test_create_account.php">Create Account</a></li>
            <li><a href="/~kmr54/IT202/Project/test/test_list_account.php">View Accounts</a></li>
            <li><a href="/~kmr54/IT202/Project/test/test_create_transactions.php">Create Transaction</a></li>
            <li><a href="/~kmr54/IT202/Project/test/test_list_transactions.php">View Transaction</a></li>
	    <li><a href="#">Deposit</a></li>
	    <li><a href="#">Withdraw</a></li>
	    <li><a href="#">Transfer</a></li>
        <?php endif; ?>
        <?php if (is_logged_in()): ?>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
