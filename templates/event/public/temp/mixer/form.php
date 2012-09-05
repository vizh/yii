<?php
$data = $this->Data;
?>

<style type="text/css">
  .cfldset input{
    width: 495px;
    height: 22px;
    line-height: 22px;
    padding-left: 5px;
    margin-bottom: 5px;
  }
  .cfldset textarea{
    width: 495px;
    padding-left: 5px;
    margin-bottom: 5px;
  }
  .cfldset p{
    margin-bottom: 10px;
    color: #aaaaaa;
  }

  .cfldset label span{
    color: #cc0000;
    font-size: 14px;
  }
</style>

<form id="event_form" action="" method="post">

<div class="cfldset">

  <h3 id="form">Fill out the form</h3>

  <label>Name of your startup:<span>*</span></label>
  <p><input name="data[name]" type="text" autocomplete="off" value="<?=isset($data['name']) ? CHtml::encode($data['name']) : '';?>"></p>

  <label>Website:<span>*</span></label>
  <p><input name="data[website]" type="text" autocomplete="off" value="<?=isset($data['website']) ? CHtml::encode($data['website']) : '';?>"></p>

  <label>1-liner:<span>*</span></label>
  <p>
    <input name="data[liner]" type="text" autocomplete="off" value="<?=isset($data['liner']) ? CHtml::encode($data['liner']) : '';?>"><br>
    Describe your startup in one sentence ("Facebook for kittens” or “Quora for college students”)
  </p>
  <label>Contact info:<span>*</span></label>
  <p>
    <textarea name="data[contactinfo]" cols="30" rows="3"><?=isset($data['contactinfo']) ? CHtml::encode($data['contactinfo']) : '';?></textarea><br>
    Founders: Name, title, email, telephone, skype, twitter of contact person
  </p>

  <label>Explain the problem you're solving:<span>*</span></label>
  <p>
    <textarea name="data[problems]" cols="30" rows="3"><?=isset($data['problems']) ? CHtml::encode($data['problems']) : '';?></textarea><br>
    (500 characters or less)
  </p>

  <label>Describe the solution you provide:<span>*</span></label>
  <p>
    <textarea name="data[describe]" cols="30" rows="3"><?=isset($data['describe']) ? CHtml::encode($data['describe']) : '';?></textarea><br>
    (500 characters or less)
  </p>

  <label>How do you make or plan to make money?<span>*</span></label>
  <p>
    <textarea name="data[moneyplan]" cols="30" rows="3"><?=isset($data['moneyplan']) ? CHtml::encode($data['moneyplan']) : '';?></textarea>
  </p>

  <label>What have you done so far?<span>*</span></label>
  <p>
    <textarea name="data[stageofproduct]" cols="30" rows="3"><?=isset($data['stageofproduct']) ? CHtml::encode($data['stageofproduct']) : '';?></textarea><br>
    Do you have an alpha/beta/final? What stage is your product at?
  </p>

  <label>Who's your competitor?<span>*</span></label>
  <p>
    <textarea name="data[competitor]" cols="30" rows="3"><?=isset($data['competitor']) ? CHtml::encode($data['competitor']) : '';?></textarea><br>
    Who do you fear the most and why? Prove us that you understand your competition!
  </p>

  <label>Describe your team:<span>*</span></label>
  <p>
    <textarea name="data[team]" cols="30" rows="3"><?=isset($data['team']) ? CHtml::encode($data['team']) : '';?></textarea><br>
    Brief info about each member of your team and their role in the startup
  </p>

  <label>Are you already incorporated?<span>*</span></label>
  <p>
    <select name="data[incorporated]">
      <option value=""></option>
      <option <?if(isset($data['incorporated']) && $data['incorporated'] == 'yes'):?>selected="selected"<?endif;?> value="yes">Yes</option>
      <option <?if(isset($data['incorporated']) && $data['incorporated'] == 'no'):?>selected="selected"<?endif;?> value="no">No</option>
    </select>
  </p>

  <label>If yes, where and when?</label>
  <p><input name="data[incorporatedinfo]" type="text" autocomplete="off" value="<?=isset($data['incorporatedinfo']) ? CHtml::encode($data['incorporatedinfo']) : '';?>"></p>


<label>Are you already funded?<span>*</span></label>
  <p>
    <select name="data[funded]">
      <option value=""></option>
      <option <?if(isset($data['funded']) && $data['funded'] == 'yes'):?>selected="selected"<?endif;?> value="yes">Yes</option>
      <option <?if(isset($data['funded']) && $data['funded'] == 'no'):?>selected="selected"<?endif;?> value="no">No</option>
    </select>
  </p>

  <label>If yes, how much and by whom?</label>
  <p>
    <input name="data[fundedinfo]" type="text" autocomplete="off" value="<?=isset($data['fundedinfo']) ? CHtml::encode($data['fundedinfo']) : '';?>"><br>
    How much have you put your own money and how much has been invested by other parties? Who are the other parties (angels, VCs etc.?)
  </p>


  <label>Are you or have you been part of some accelerator/incubator?<span>*</span></label>
    <p>
      <select name="data[partofsomething]">
        <option value=""></option>
        <option <?if(isset($data['partofsomething']) && $data['partofsomething'] == 'yes'):?>selected="selected"<?endif;?> value="yes">Yes</option>
        <option <?if(isset($data['partofsomething']) && $data['partofsomething'] == 'no'):?>selected="selected"<?endif;?> value="no">No</option>
      </select>
    </p>

    <label>If yes, which one?</label>
    <p><input name="data[pertofsomethinginfo]" type="text" autocomplete="off" value="<?=isset($data['pertofsomethinginfo']) ? CHtml::encode($data['pertofsomethinginfo']) : '';?>"></p>


  <label>URL to your pitch deck:</label>
    <p><input name="data[urltodeck]" type="text" autocomplete="off" value="<?=isset($data['urltodeck']) ? CHtml::encode($data['urltodeck']) : '';?>"></p>

    <label>URL to your online product demo:</label>
    <p><input name="data[urltodemo]" type="text" autocomplete="off" value="<?=isset($data['urltodemo']) ? CHtml::encode($data['urltodemo']) : '';?>"></p>

    <label>Any additional relevant information:</label>
    <p>
      <textarea name="data[additionalinfo]" cols="30" rows="3"><?=isset($data['additionalinfo']) ? CHtml::encode($data['additionalinfo']) : '';?></textarea><br>
      (500 characters or less)
    </p>


  <!-- end cfldset -->
</div>

<div style="width: 280px; margin-bottom: 30px;" class="response">
  <a href="" onclick="$('#event_form')[0].submit(); return false;">Send</a>
</div>

</form>