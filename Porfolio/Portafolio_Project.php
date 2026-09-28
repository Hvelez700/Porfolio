
<html>
<head><title>Portafolio Project</title></head>
<link rel="stylesheet" href="Css_File/Portafolio.css">
<link rel="stylesheet" href="normalize.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--boostrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


<body id="body1">

<nav id="wrapper2">
<ul>
<li><a href="#aboutme">About me</a></li>
<li><a href="Project.html">Projects</a></li>
<li><a href="#contact">Contact me</a></li>
</ul>
</nav>





<div class="wrapper">
<div id="div_border">
</div>
<img src="pic/Hernan.JPG" class="pic">

<div class="name_background">
<h3 class="about_me">Hi my name is Hernan and Iam a Computer Programmer</h3>
</div>

<div class="about_me_div">
<img src="pic/Hernan_pic2.JPG" class="pic2">


<div class="div_body">

<nav class="nav_header">
<h1 id="aboutme">About Me</h1>
</nav>
<strong class="info">Hi My name is Hernan and Iam a Computer Programmer<br>
Hope you like navigating through my Porfolio. <br>
At the bottom are some of my projects for you to check out.<br>
The earth project That gives you facts about the planet, or click on the football Logo.<br>
This will take you to my Favorite football website.<br>
<p > <a href="#wrapper2" class="top" >Back to top</a></p>

</strong>


</div>


</div>

<section id="projects">
<div class="Project">
<h2 class="hp">Projects</h2>
<div class="Projects">
<div class="earth_project">
<img class="rumbleImg" src="Pic/earth.jpg">
<div class="text">

<h3 class="project-name">Earth Facts</h3>
<div class="content">
<p>A HTML project about facts about the earth</p>

</div>
<a class="button" href="https://science.nasa.gov/earth/facts/" target="_black">View Website</a>

</div>

</div>

<div class="rumble_project">
<img class="rumbleImg" src="Pic/Rumble.png">
<div class="text">

<h3 class="project-name">Rumble website</h3>

<div class="content">
<p>A Youtube alternative website.</p>

</div>
<a class="button" href="https://rumble.com/" target="_blank">View Website</a>

</div>

</div>

</div>



</div>


</section>

<section id="contactme" class="contact">
<h2>Contact</h2>
<p>Use this form to get in touch with me.</p>
<div id="error"><?php require "Email.php" ?></div>

<form class="contact-form" id="contact-form" method="POST" action="" enctype="multipart/form-data">
<div class="contact-info">
<label for="name">Name</label>
<input type="text" id="name" placeholder="Enter your name" class="form-control" name="name">

<label for="to_email">Send To Email</label>
<input type="email" id="to_email" placeholder="Recipient email address" class="form-control" name="to_email">

<label for="subject">Subject</label>
<input type="text" id="subject" placeholder="Enter your subject" class="form-control" name="subject">

<label for="email">Your Email (Reply-To)</label>
<input type="email" id="email" placeholder="Enter your Email" class="form-control" name="email">
</div>

<div class="message">
<label for="msg">Message</label>
<label for="attachment">Attach Folder (.zip file):</label>
<input 
  type="file" 
  id="attachment" 
  name="attachment" 
  accept=".zip,.rar,.7z" 
  class="form-control mb-3"
/>

<textarea id="msg" rows="15"  class="form-control" name="msg">
    
</textarea>

<button type="submit" id="submit" class="btn btn-primary">Submit</button>
</div>

</form>


</section>


<footer>
<div class="container">
<div class="copyright">
This site &copy; 2025 Hernan Velez
</div>

<div class="social-media">

<a href=""><i class="fa fa-github" style="font-size:36px"></i></a>



</div>

</div>
</footer>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" 
 integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" 
 crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" 
integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" 
crossorigin="anonymous"></script>
<script src="Javascript/Email.js"></script>
<script src="Javascript/Porfolio_script.js"></script>


</script>


</div>


</body>


</html>