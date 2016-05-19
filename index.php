<?php include('header.php'); ?>
<?php include('app/core/helper/formHelper.php'); ?>
<?php include('app/core/validation/validation.php'); ?>
<div class="container">
<div class="jumbotron">
   
  <h1>Create From</h1>
<?php 
 $username = '' ;
 $password = '' ;
 $address  = '' ;
 $shirts   = '' ;
 $gender   = '' ;
 $newsletter='' ;
if(isset($_POST['submit'])){
    echo "<pre>";
    $username_validation_rules = [
                                  'required',
                                  'alpha'
                            ];

     $password_validation_rules = [
                                    'required',
                                     'min_length_6'
                            ];
     $address_validation_rules = [
                                    'required',
                                     'max_length_10'
                            ];
      $shirts_validation_rules = array('required');
      $gender_validation_rules = array('required');
      $newsletter_validation_rules = array('required');
     if(isset($_POST['username'])){
      $username = $_POST['username'];
     }
     if(isset($_POST['password'])){
      $password = $_POST['password'];
    }
     if(isset($_POST['address'])){
      $address = $_POST['address'];
    }
     if(isset($_POST['shirts'])){
      $shirts = $_POST['shirts'];
    }
     if(isset($_POST['gender'])){
      $gender = $_POST['gender'];
    }
     if(isset($_POST['newsletter'])){
      $newsletter = $_POST['newsletter'];
    }
     
      
     
       
     $validation_result_username = validation_set('username',$username,$username_validation_rules);
     $validation_result_password = validation_set('password',$username,$password_validation_rules);
     $validation_result_address = validation_set('address',$username,$address_validation_rules);
     $validation_result_shirts = validation_set('shirts',$username,$shirts_validation_rules);
     $validation_result_gender = validation_set('gender',$username,$gender_validation_rules);
     $validation_result_newsletter = validation_set('newsletter',$username,$newsletter_validation_rules);
   
   if(!empty($validation_result_username)){
       print_r($validation_result_username);
          echo "<br>";
      }

    if(!empty($validation_result_password)){
       print_r($validation_result_password);
          echo "<br>";
      }

    if(!empty($validation_result_address)){
       print_r($validation_result_address);
          echo "<br>";
      }

      if(!empty($validation_result_shirts)){
       print_r($validation_result_shirts);
          echo "<br>";
      }
     
     if(!empty($validation_result_gender)){
       print_r($validation_result_gender);
          echo "<br>";
      }

      if(!empty($validation_result_newsletter)){
       print_r($validation_result_newsletter);
          echo "<br>";
      }

  echo "</pre>";
}

?>



  

  <?php
      $attributes_form_tag = array('class' => 'email form-horizontal', 'id' => 'myform');
      $attributes_lable = array('class' => 'col-lg-2 control-label','style' => 'color: #000;',);
      $data_input = array(
              'name'        => 'username',
              'id'          => 'username',
              'class'       => 'form-control',
              'placeholder' => 'User Id',
              'maxlength'   => '100',
              'size'        => '50',
              'style'       => 'width:50%',
            );
      $data_pass = array(
              'name'        => 'password',
              'id'          => 'password',
              'class'       => 'form-control',
              'placeholder' => 'password',
              'maxlength'   => '100',
              'size'        => '50',
              'style'       => 'width:50%',
            );
      $data_textarea = array(
              'name'        => 'address',
              'id'          => 'address',
              'class'       => 'form-control',
              'placeholder' => 'address',
              'rows'        => '4',
              'cols'        => '5',
              'style'       => 'width:50%',
            );
      $options = array(
                  ''       =>'Select Options',
                  'small'  => 'Small Shirt',
                  'med'    => 'Medium Shirt',
                  'large'   => 'Large Shirt',
                  'xlarge' => 'Extra Large Shirt',
                );
      $data_reset = array(
                  'name' => 'reset',
                  'id' => 'reset_button',
                  'class' => 'btn btn-default',
                  'value' => 'Cancel',
                  'content' => 'Cancel'
              );
      $data_submit = array(
                  'name' => 'submit',
                  'id' => 'submit_button',
                  'class' => 'btn btn-primary',
                  'value' => 'Submit',
                  'content' => 'Submit'
              );
?>
<?php echo start_form('', $attributes_form_tag); ?>
 <?php echo fieldset('Form'); ?>
    <div class="form-group">
        <?php echo label('Name', 'username',$attributes_lable); ?>
      
      <div class="col-lg-10">
        <?php echo input_text($data_input); ?>
      </div>
    </div>
    <div class="form-group">
        <?php echo label('Password', 'password',$attributes_lable); ?>
      <div class="col-lg-10">
        <?php echo input_password($data_pass); ?>
      </div>
    </div>
    <div class="form-group">
        <?php echo label('Textarea', 'textArea',$attributes_lable); ?>
      <div class="col-lg-10">
        <?php echo textarea($data_textarea); ?>
        
      </div>
    </div>
    <div class="form-group">
      <div class="row col-lg-offset-2">
        <div class="col-lg-4">
          <dvi class="col-lg-2">
            <?php echo label('Male', 'male') ?>
          </dvi>
          <dvi class="col-lg-2">
             <?php echo radio('gender', 'M', '', 'id=male'); ?>
          </dvi>
        </div>
        <div class="col-lg-4">

          <dvi class="col-lg-2">
             <?php echo label('Female', 'female') ?>
          </dvi>
           <dvi class="col-lg-2">
             <?php echo radio('gender', 'F', '', 'id=female'); ?>
           </dvi>
        </div>
        <div class="col-lg-4"></div>
    </div>
    </div>
    <div class="form-group">
        <?php echo label('Select your shirts size', 'shirts',$attributes_lable); ?>
      
      <div class="col-lg-10">
       <?php echo select('shirts', $options, ''); ?>

      </div>
    </div>
    <div class="form-group">
    <div class="col-lg-4">      
    <p>Click the checkbox to confirm </p>
    </div>
      <div class="col-lg-8">
        <div class="checkbox">
        
         <?php echo checkbox('newsletter', 'accept'); ?>
          
        </div>
      </div>
    </div>
    
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <?php  echo cancel($data_reset); ?> 
        <?php echo submit($data_submit); ?>
      </div>
    </div>
  <?php echo end_fieldset();  ?>
<?php echo end_form(); ?>

</div>
</div>
<?php include('footer.php'); ?> 

