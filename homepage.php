<?php

require "Common.php";
require "Authorization.php";

if (!isset($_SESSION['email']))
{
    redirect('index.php');
}
else
{

MakeHeader("Home", "homepage");

?>

	<nav class="navbar sticky-top navbar-expand-lg  navbar-dark bg-dark">
  		<a class="navbar-brand logo" href="#">MyFIT</a>
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>

  		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    		<ul class="navbar-nav mr-auto">
      			<li class="nav-item active">
        			<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      			</li>
      			<li class="nav-item active">
        			<a class="nav-link" href="#">My profile <span class="sr-only">(current)</span></a>
      			</li>
      			<li class="nav-item active">
        			<a class="nav-link" href="signout.php">Sign out<span class="sr-only">(current)</span></a>
      			</li>
    		</ul>
    		<form class="form-inline my-2 my-lg-0">
      			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      			<button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
    		</form>
  		</div>
	</nav>
	
	<div class="container-fluid">
  		<div class="col-12 col-md-3 col-xl-2 bd-sidebar sidebar">
			<ul>
 				<li>Lorem ipsum dolor sit amet</li>
				<li>Consectetur adipiscing elit</li>
  				<li>Integer molestie lorem at massa</li>
  				<li>Facilisis in pretium nisl aliquet</li>
  				<li>Nulla volutpat aliquam velit
    				<ul>
      					<li>Phasellus iaculis neque</li>
      					<li>Purus sodales ultricies</li>
      					<li>Vestibulum laoreet porttitor sem</li>
      					<li>Ac tristique libero volutpat at</li>
    				</ul>
  				</li>
  				<li>Faucibus porta lacus fringilla vel</li>
  				<li>Aenean sit amet erat nunc</li>
  				<li>Eget porttitor lorem</li>
			</ul>
		</div>
	</div>

<?php
}


/*
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
  		<a class="navbar-brand" href="#">MyFIT</a>
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>

  		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    		<ul class="navbar-nav mr-auto">
      			<li class="nav-item active">
        			<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      			</li>
      			<li class="nav-item">
        			<a class="nav-link" href="#">Link</a>
      			</li>
      			<li class="nav-item dropdown">
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          				Dropdown
        			</a>
        			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
          				<a class="dropdown-item" href="#">Action</a>
          				<a class="dropdown-item" href="#">Another action</a>
          				<div class="dropdown-divider"></div>
          				<a class="dropdown-item" href="#">Something else here</a>
        			</div>
      			</li>
      			<li class="nav-item">
        			<a class="nav-link disabled" href="#">Disabled</a>
      			</li>
    		</ul>
    		<form class="form-inline my-2 my-lg-0">
      			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    		</form>
  		</div>
	</nav> */