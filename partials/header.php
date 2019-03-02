<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-3" id="loggedInName">
                <a class="btn btn-outline-primary btn-sm float-left" href="/memberSettingsForm.php"><?php echo $_SESSION[username] ?></a>
            </div>

            <div class="col-6 text-center" id="logo-container">
                <a class="blog-header-logo text-dark" href="/points">Ramblin' Reck Club</a>
            </div>
            <div class="col-3 d-flex justify-content-end align-items-center" id="userOptions">
                <a id="sign-out-button" class="btn btn-sm btn-secondary" href="/memberLogout.php">Sign Out</a>
            </div>
        </div>
    </header>
    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            <a class="p-2" href="/events.php">Events</a>
            <a class="p-2" href="/rankings.php">Members</a>
            <a class="p-2" href="/families.php">Families</a>
<!--            <a class="p-2" href="http://reckclub.org/mediastorage">Media</a>-->
            <?php if($isSecretary == 1 || $isVP == 1 || $isEventAdmin == 1 || $isAdmin == 1) :?>
            <a class="p-2 dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Admin</a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="/editEvents.php">Add Event</a>
                <?php if($isSecretary == 1 || $isVP == 1 || $isAdmin == 1) :?>
                    <a class="dropdown-item" href="/manageMembers.php">Manage Members</a>
                    <a class="dropdown-item" href="/manageWebsite.php">Manage Site</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </nav>
    </div>
</div>