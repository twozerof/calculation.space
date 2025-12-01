<?php ob_start() ?>
      <article class="main_article">
        <h1 class="main_article_title">Калькулятор термосопротивлений</h1>
        <div class="calculator">
          <form id="rtd-calculator">
            <fieldset>
              <div class="form-group">
                <label for="type-rtd">Тип термосопротивления</label>
                <select id="type-rtd" name="type">
<?php foreach($data['list_type'] as $key => $type): ?>
                  <option value="<?= $key ?>"><?= $type['type'] ?>, α=<?=$type['a']?>, <?=$type['r']?> Ом (<?= $type['start'] ?>...<?= $type['end'] ?> °C)</option>
<?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <span>Направление расчёта</span>
                <div class="radio-group">
                  <input type="radio" data-placeholder="Температура, °C" class="btn-check" name="convert" id="vbtn-radio1" autocomplete="off" value="0" checked>
                  <label for="vbtn-radio1"><strong>температура → сопротивление</strong></label>
                  <input type="radio" data-placeholder="Сопротивление, Ом" class="btn-check" name="convert" id="vbtn-radio2" autocomplete="off" value="1">
                  <label for="vbtn-radio2"><strong>сопротивление → температура</strong></label>
                </div>
              </div>
              <div class="form-group">
                <label for="value">Параметр</label>
                <input type="number" name="value" id="value" placeholder="Температура, °C" step="0.01" value="">
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
      <script src="static/js/rtd.js"></script>
      <script src="static/js/scripts.js"></script>
<?php $content = ob_get_clean() ?>
<?php include 'views/layout.php';