<div class="contact-list">
  <input class="form-control rounded mb-2" type="text" placeholder="⌕ Buscar...">
  <h5>Chats recientes</h5>

  <?php if (!empty($contacts)): ?>

    <?php foreach ($contacts as $key => $value): ?>
      <div class="contact-item pb-0">

        <div class="d-flex justify-content-between pb-0">
          <div>
            <span class="small">
              <strong>
                +<?php echo mb_substr($value->phone_contact, 0, 2); ?>
                 <?php echo mb_substr($value->phone_contact, 2, 3); ?>
                 <?php echo mb_substr($value->phone_contact, 5, 7); ?>
              </strong>
            </span>
          </div>
          <div>

            <?php if (!empty($messages)): ?>
              <?php if (date("Y-m-d") == TemplateController::formatDate(8, end($messages)->date_updated_message)): ?>
                <span class="small"><?php echo TemplateController::formatDate(6, end($messages)->date_updated_message); ?></span>
              <?php else: ?>
                <span class="small"><?php echo TemplateController::formatDate(5, end($messages)->date_updated_message); ?></span>
              <?php endif ?>
            <?php endif ?>

          </div>
        </div>

        <div class="d-flex justify-content-between pb-0">
          <div>
            <?php if (!empty($messages)): ?>
              <?php if (end($messages)->type_message == "business"): ?>
                <p class="small">...</p>
              <?php else: ?>
                <p class="small"><?php echo mb_substr(end($messages)->client_message, 0, 17) . "..."; ?></p>
              <?php endif ?>
            <?php endif ?>
          </div>

          <div class="custom-control custom-checkbox">
            <input
            type="checkbox"
            class="custom-control-input mt-2 form-check-input"
            id="customCheck"
            name="example1"

            <?php if ($value->ai_contact == 1): ?> checked
            <?php endif ?>

            style="width:18px !important; height:18px !important">
            <label class="custom-control-label mb-1" for="customCheck"><i class="fas fa-robot text-success"></i></label>
          </div>
        </div>

      </div>
    <?php endforeach ?>

  <?php endif ?>

</div>
