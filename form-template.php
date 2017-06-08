<div class="et-elegant-crm">
  <form action="add_crm_customer" class="et-elegant-crm__form js-et-elegant-crm__form">
    <div class="et-elegant-crm__field -half">
      <input type="text" class="et-elegant-crm__field__input" name="name" maxlength="<?php echo $name_maxlength; ?>" required />
      <label class="et-elegant-crm__field__label"> <?php echo $name_label; ?> </label>
      <div class="et-elegant-crm__field__bar"></div>
    </div>
    <div class="et-elegant-crm__field -half">
      <input type="phone" class="et-elegant-crm__field__input" name="phone" maxlength="<?php echo $phone_maxlength; ?>" required />
      <label class="et-elegant-crm__field__label"> <?php echo $phone_label; ?> </label>
      <div class="et-elegant-crm__field__bar"></div>
    </div>
    <div class="et-elegant-crm__field -half">
      <input type="email" class="et-elegant-crm__field__input" name="email" maxlength="<?php echo $email_maxlength; ?>" required />
      <label class="et-elegant-crm__field__label"> <?php echo $email_label; ?> </label>
      <div class="et-elegant-crm__field__bar"></div>
    </div>
    <div class="et-elegant-crm__field -half">
      <input type="text" class="et-elegant-crm__field__input" name="budget" maxlength="<?php echo $budget_maxlength; ?>" required />
      <label class="et-elegant-crm__field__label"> <?php echo $budget_label; ?> </label>
      <div class="et-elegant-crm__field__bar"></div>
    </div>
    <div class="et-elegant-crm__field">
      <textarea class="et-elegant-crm__field__textarea" name="message" maxlength="<?php echo $message_maxlength; ?>" rows="<?php echo $message_rows; ?>" cols="<?php echo $message_cols; ?>" required></textarea>
      <label class="et-elegant-crm__field__label"> <?php echo $message_label; ?> </label>
      <div class="et-elegant-crm__field__bar"></div>
    </div>
    <?php wp_nonce_field('et_elegant_crm__security', 'security'); ?>
    <button class="et-elegant-crm__btn">Submit</button>
  </form>
</div>