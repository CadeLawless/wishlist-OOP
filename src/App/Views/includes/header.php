<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/site-images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <link rel="stylesheet" type="text/css" href="css/snow.css" />
    <title><?= $title ?? "Wish List"; ?></title>
</head>
<body class="<?php if($user->dark_theme) echo "dark"; ?>">
    <div id="body">
        <?php
        $currentPage = explode("?", $_SERVER["REQUEST_URI"])[0];
        ?>
        <div class="header-container">
            <div class="header">
                <div class="title">
                    <a class="nav-title" href="index.php"><?php require("images/site-images/logo.php"); ?></a>
                    <a href="#" class="dark-mode-link"><?php require("images/site-images/icons/dark-mode.php"); ?></a>
                    <a href="#" class="light-mode-link"><?php require("images/site-images/icons/light-mode.php"); ?></a>
                </div>
                <div class="menu">
                    <?php
                    require("images/site-images/hamburger-menu.php");
                    require("images/site-images/menu-close.php");
                    ?>
                    <div class="menu-links">
                        <a class="nav-link<?php if($currentPage == "/wishlist/index.php") echo " active"; ?>" href="index.php">Home<div class="underline"></div></a>
                        <a class="nav-link<?php if($currentPage == "/wishlist/create-wishlist.php") echo " active"; ?>" href="create-wishlist.php">Create Wishlist<div class="underline"></div></a>
                        <a class="nav-link<?php if(in_array($currentPage, ["/wishlist/view-wishlists.php", "/wishlist/view-wishlist.php", "/wishlist/add-item.php", "/wishlist/edit-item.php"])) echo " active"; ?>" href="view-wishlists.php">View Wishlists<div class="underline"></div></a>
                        <div class="nav-link dropdown-link profile-link<?php if(in_array($currentPage, ["/wishlist/admin-center.php", "/wishlist/view-profile.php", "/wishlist/backgrounds.php", "/wishlist/edit-user.php", "/wishlist/add-background.php","/wishlist/edit-background.php", "/wishlist/gift-wraps.php", "/wishlist/add-gift-wrap.php", "/wishlist/edit-gift-wrap.php", "/wishlist/wishlists.php"])) echo " active-page"; ?>">
                            <div class="outer-link">
                                <span class="profile-icon"><?php require("images/site-images/profile-icon.php"); ?></span>
                                <span>My Account</span>
                                <span class="dropdown-arrow"><?php require("images/site-images/dropdown-arrow.php"); ?></span>
                            </div>
                            <div class="underline"></div>
                            <div class="dropdown-menu hidden">
                                <a class="dropdown-menu-link" href="view-profile.php">View Profile</a>
                                <?php if($admin){ ?>
                                    <a class="dropdown-menu-link" href="admin-center.php">Admin Center</a>
                                <?php } ?>
                                <a class="dropdown-menu-link" href="logout.php">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.querySelector(".hamburger-menu").addEventListener("click", function(){
                this.classList.add("hidden");
                document.querySelector(".close-menu").classList.remove("hidden");
                document.querySelector(".menu-links").style.display = "flex";
                document.querySelector(".menu-links").classList.remove("hidden");
            });
            document.querySelector(".close-menu").addEventListener("click", function(){
                this.classList.add("hidden");
                document.querySelector(".hamburger-menu").classList.remove("hidden");
                document.querySelector(".menu-links").classList.add("hidden");
            });
            window.addEventListener("click", function(e){
                if(document.querySelector(".menu-links").style.display == "flex"){
                    if(!e.target.classList.contains("header") && !document.querySelector(".header").contains(e.target)){
                        document.querySelector(".close-menu").click();
                    }
                }
                if(!document.querySelector(".dropdown-menu").classList.contains("hidden")){
                    if(!e.target.classList.contains("dropdown-menu") && !e.target.classList.contains("dropdown-link") && !document.querySelector(".dropdown-link").contains(e.target)){
                        document.querySelector(".dropdown-link").click();
                    }
                }
            });
            document.querySelector(".dropdown-link").addEventListener("click", function(e){
                let dropdown_menu = this.querySelector(".dropdown-menu");
                if(dropdown_menu.classList.contains("hidden")){
                    dropdown_menu.classList.remove("hidden");
                    this.classList.add("active");
                }else{
                    if(!e.target.classList.contains("dropdown-menu-link")){
                        dropdown_menu.classList.add("hidden");
                        this.classList.remove("active");
                    }
                }
            });
        </script>
        <div id="container">
