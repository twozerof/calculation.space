<?php ob_start() ?>
      <article class="main_article">
        <h1 class="main_article_title">Калькулятор NTC</h1>
        <div class="calculator">
          <form id="b-ntc-calculator">
            <fieldset>
              <div class="input-two-column">
                <div class="form-group">
                  <label for="temperature_1">Температура 1, °C</label>
                  <input type="number" name="temperature_1" id="temperature_1" placeholder="Температура, °C" step="0.01" value="">
                </div>
                <div class="form-group">
                  <label for="resistance">Сопротивление 1, Ом</label>
                  <input type="number" name="resistance_1" id="resistance" placeholder="Сопротивление, Ом" step="0.01" value="">
                </div>
                <div class="form-group">
                  <label for="temperature_2">Температура 2, °C</label>
                  <input type="number" name="temperature_2" id="temperature_2" placeholder="Температура, °C" step="0.01" value="">
                </div>
                <div class="form-group">
                  <label for="resistance_2">Сопротивление 2, Ом</label>
                  <input type="number" name="resistance_2" id="resistance_2" placeholder="Сопротивление, Ом" step="0.01" value="">
                </div>
              </div>
            </fieldset>
          </form>
          <div class="results" id="b-calculation-result">
            <div id="result-value"></div>
          </div>
        </div>
        <form id="ntc-calculator">
            <fieldset>
              <div class="form-group">
                <label for="temperature_1">Температура при которой сопротивление равно номинальному, °C</label>
                <input type="number" name="temperature_1" id="temperature_1" placeholder="Температура, °C" step="0.01" value="25">
              </div>
              <div class="form-group">
                <label for="resistance_1">Номинальное сопротивление, Ом</label>
                <input type="number" name="resistance_1" id="resistance_1" placeholder="Сопротивление, Ом" step="1" value="10000">
              </div>
              <div class="form-group">
                <label for="b">Коэффициент температурной чувствительности (B)</label>
                <input type="number" name="b" id="b" placeholder="Коэффициент температурной чувствительности (B)" step="1" value="3950">
              </div>
              <div class="form-group">
                <label for="tolerance">Допуск, %</label>
                <input type="number" name="tolerance" id="tolerance" placeholder="Допуск, %" step="0.1" value="5">
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
        <section>
          <!--<h2 class="section_title">Как пользоваться?</h2>-->
          <p></p>
        </section>
      </article>
      <script src="static/js/ntc.js"></script>
      <script src="static/js/scripts.js"></script>
<?php $content = ob_get_clean() ?>
<?php include 'views/layout.php';