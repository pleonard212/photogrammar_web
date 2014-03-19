<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no,maximum-scale=1, initial-scale=1.0 ">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Photogrammar</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
  </head>
<!-- NAVBAR
================================================== -->
  <body <?php echo $bodyopts ?>>

    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/"><img src="http://photogrammar.yale.edu/images/photogrammar-wordmark.jpg" alt="Yale Photogrammar" title="Yale Photogrammar" height=50px /></a></a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li class="<?php echo ($page == "home" ? "active" : "")?>"><a href="/">Home</a></li>
                <li class="<?php echo ($page == "map" ? "active" : "")?>"><a href="/map">Map</a></li>
                <li class="<?php echo ($page == "search" ? "active" : "")?>"><a href="/search">Search</a></li>
                <li class="dropdown <?php echo ($page == "about" ? "active" : "")?>">
                  <a href="#" class="dropdown-toggle <?php echo ($page == "about" ? "active" : "")?>" data-toggle="dropdown">About<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="/about/fsa_owi">FSA-OWI</a></li>
                    <li><a href="/about/team">Team</a></li>
                    <li><a href="/about/partners">Partners</a></li>
                    <li class="divider"></li>
                    <li><a href="/about/contact">Contact</a></li>
                    <li><a href="/blog">Blog</a></li>
                  </ul>
                </li>
                <li class="<?php echo ($page == "labs" ? "active" : "")?>"><a href="/labs">Labs</a></li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>

