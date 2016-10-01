__template:app
__templateVariable:title, Contact Us

__templateContent
<div class="container">
  <div class="row-fluid">
    <div class="span12">
      <div class="page-header">
        <div class="row-fluid">
          <div class="span12">
            <h1> Contact Us</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row-fluid contact">
    <div class="span4">
      <ul class="bordered-list">
        <li class="img-location">123 - White Street, Near Something Solid</li>
        <li class="img-phone"><b>Phone:</b> 088 5548 5548</li>
        <li class="img-skype last"><b>Skype:</b> agency</li>
      </ul>
    </div>
    <div class="span6">
      <div class="wpcf7" id="wpcf7-f75-t1-o1">
        <form action="" method="post" class="wpcf7-form" id="cform" name="cform">
          <div id="output" class="alert"> </div>
          <div class="form-meta clearfix">
            <div class="formcol">
              <label for="fname"> First Name</label>
              <input type="text" name="fname" value="" id="fname" size="40" />
              <label for="lname"> Last Name</label>
              <input type="text" name="lname" value="" id="lname" size="40" />
            </div>
            <div class="formcol">
              <label for="email"> Email Address</label>
              <input type="text" name="email" id="email" value="" size="40" />
              <label for="subject"> Subject</label>
              <input type="text" name="subject" id="subject" value="" size="40" />
            </div>
          </div>
          <label for="message"> Message</label>
          <textarea name="message" id="message" cols="40" rows="10"></textarea>
          <input type="submit" id="send-message" value="Send" class="btn btn-success" />
        </form>
      </div>
    </div>
  </div>
</div>
__end
