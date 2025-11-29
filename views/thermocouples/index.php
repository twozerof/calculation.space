<?php ob_start() ?>
      <article class="main_article">
        <h1 class="main_article_title">Калькулятор термопар</h1>
        <div class="calculator">
          <form id="thermocouple-calculator">
            <fieldset>
              <div class="form-group">
                <label for="type-tc">Тип термопары</label>
                <select id="type-tc" name="type">
<?php foreach($data['list_type'] as $key => $type): ?>
                  <option value="<?= $key ?>"><?= $type['type'] ?> (<?= $type['start'] ?>...<?= $type['end'] ?> °C)</option>
<?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <span>Направление расчёта</span>
                <div class="radio-group">
                  <input type="radio" data-placeholder="Температура, °C" class="btn-check" name="convert" id="vbtn-radio1" autocomplete="off" value="0" checked>
                  <label for="vbtn-radio1"><strong>температура → термо-ЭДС</strong></label>
                  <input type="radio" data-placeholder="термо-ЭДС, mV" class="btn-check" name="convert" id="vbtn-radio2" autocomplete="off" value="1">
                  <label for="vbtn-radio2"><strong>термо-ЭДС → температура</strong></label>
                </div>
              </div>
              <div class="form-group">
                <label for="value">Параметр</label>
                <input type="number" name="value" id="value" placeholder="Введите значение" step="0.0001" value="">
              </div>
              <div class="form-group">
                <label for="compensation">Температура холодного спая, °C</label>
                <input type="number" name="compensation" id="compensation" placeholder="0" step="0.01" value="0">
              </div>
            </fieldset>
            <!--<button type="submit" name="ok">Рассчитать</button>-->
          </form>
          <div class="results" id="calculation-result">
            <div id="result-value"></div>
          </div>
        </div>
        <section>
          <!--<h2 class="section_title">Как пользоваться?</h2>-->
          <p></p>
        </section>
      </article>
      <script src="static/js/thermocouples.js"></script>
<?php $content = ob_get_clean() ?>
<?php include 'views/layout.php';