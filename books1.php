<?php 
    require "db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SQL Injection demo">
    <meta name="author" content="Francesco Borzì">

    <title>SQL Injection Demo</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body class="mainstream js-enabled">
    <header role="banner" id="global-header">
      <div class="header-wrapper">
        <div class="header-global">
          <div class="header-logo">
            <a href="https://www.gov.uk" title="Go to the GOV.UK homepage" id="logo" class="content">
              <img src="https://assets.publishing.service.gov.uk/static/gov.uk_logotype_crown_invert_trans-203e1db49d3eff430d7dc450ce723c1002542fe1d2bce661b6d8571f14c1043c.png" alt="" width="36" height="32"> GOV.UK
            </a>
          </div>
        </div>
      </div>
    </header>
    <div id="global-header-bar"></div>
    <div id="wrapper" class="local_transaction service">
    <div class="govuk-breadcrumbs" data-module="track-click">
      <ol>

        <li class="">
            <a data-track-category="breadcrumbClicked" data-track-action="1" data-track-label="/" data-track-options="{&quot;dimension28&quot;:&quot;3&quot;,&quot;dimension29&quot;:&quot;Home&quot;}" class="" aria-current="false" href="/">Home</a>
        </li>

        <li class="">
            <a data-track-category="breadcrumbClicked" data-track-action="2" data-track-label="/browse/housing-local-services" data-track-options="{&quot;dimension28&quot;:&quot;3&quot;,&quot;dimension29&quot;:&quot;Housing and local services&quot;}" class="" aria-current="false" href="/browse/housing-local-services">Housing and local services</a>
        </li>

        <li class="">
            <a data-track-category="breadcrumbClicked" data-track-action="3" data-track-label="/browse/housing-local-services/local-councils" data-track-options="{&quot;dimension28&quot;:&quot;3&quot;,&quot;dimension29&quot;:&quot;Local councils and services&quot;}" class="" aria-current="false" href="/browse/housing-local-services/local-councils">Local councils and services</a>
        </li>
      </ol>
    </div>
    <div class="grid-row">
        <main id="content" class="" role="main">
          <header class="page-header">
			<div class="pub-c-title pub-c-title--bottom-margin">
			  <h1 class="pub-c-title__text">
				Search the local library catalogue
			  </h1>
			</div>
		  </header>
		<div class="article-container group">
			<div class="content-block">
			  <div class="inner">
			  <form class="form-inline" role="form" action="books1.php" method="GET">
				<div class="form-group">
				  <label class="sr-only" for="exampleInputEmail2">Book title</label>
				  <input type="text" name="title" class="form-control" placeholder="Book title">
				</div>
				<div class="form-group">
				  <label class="sr-only" for="exampleInputPassword2">Book author</label>
				  <input type="text" name="author" class="form-control"placeholder="Book author">
				</div>
				<button type="submit" class="button" role="button">Search</button>
			  </form>
			  </div>
			</div>
			<div class="meta-data group">
			<p class="modified-date">Last updated: 27 February 2018</p>
		</div>
	  </div>
        </main>
        <div class="col-sm-2">
          <span class="visible-xs">&nbsp;</span>
          <a href="books1.php?all=1"><button type="button" class="btn btn-info">All books</button></a>
        </div>
      </div>
      
      <br>
      
      <table class="table table-bordered">
        <tr>
          <th>#ID</th>
          <th>Title</th>
          <th>Author</th>
        </tr>
      <?php
        if ($_GET['all'] == 1)
        {
            $query = "SELECT * FROM books;";
        }
        else if ($_GET['title'] || $_GET['author'])
        {
            $query = sprintf("SELECT * FROM books WHERE title = '%s' OR author LIKE '%%%s%%';",
                             $_GET['title'],
                             $_GET['author']);
        }
            
		if ($query != null)
		{
			$result = mysqli_query($connection, $query);

			while (($row = mysqli_fetch_row($result)) != null)
			{
				printf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row[0], $row[1], $row[2]);
			}
		}
      ?>
      </table>
      
      <hr>
      <div class="row">
        <div class="col-sm-12">
          <h4>Query Executed:</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-12">
          <div class="highlight">
            <pre><?= $query ?></pre>
          </div>
        </div>
      </div>
      
      <hr>
      <div class="row">
        <div class="col-sm-12">
          <h4>PHP Code:</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-12">
          <div class="highlight">
            <pre>
if ($_GET['all'] == 1)
{
    $query = "SELECT * FROM books;";
}
else if ($_GET['title'] || $_GET['author'])
{
    $query = sprintf("SELECT * FROM books WHERE title = '%s' OR author = '%s';",
                             $_GET['title'],
                             $_GET['author']);
}

if ($query != null)
{
    $result = mysqli_query($connection, $query);

    while (($row = mysqli_fetch_row($result)) != null)
    {
        printf("&lt;tr&gt;&lt;td&gt;%s&lt;/td&gt;&lt;td&gt;%s&lt;/td&gt;&lt;td&gt;%s&lt;/td&gt;&lt;/tr&gt;", $row[0], $row[1], $row[2]);
    }
}
            </pre>
          </div>
        </div>
      </div>
      
       <hr>
      <div class="row">
        <div class="col-sm-12">
          <h4>Vulnerability:</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-12">
          <div class="highlight">
            <pre>
Pass <strong>' UNION SELECT * FROM users WHERE '1'='1';-- </strong> as author to get all users data.<br>
The same result is obtained by using url <a href="books1.php?author=%27+UNION+SELECT+*+FROM+users+WHERE+%271%27%3D%271%27%3B--+"><strong>books1.php?author=%27+UNION+SELECT+*+FROM+users+WHERE+%271%27%3D%271%27%3B--+</strong></a>.
            </pre>
          </div>
        </div>
      </div>
      
      <br>

      <?php include("footer.php"); ?>

    </div> <!-- /container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
