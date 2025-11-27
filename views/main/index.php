<?php ob_start() ?>
      <article class="main_article">
        <h1 class="main_article_title">Калькуляторы для технических расчётов</h1>
        <section>
          <h2 class="section_title">Калькуляторы КИПиА</h2>
          <p><img src="thermometer.svg" alt="Описание SVG" id="icon">В этом разделе объединены калькуляторы по теме "Контрольно-измерительные приборы и автоматика". На данный момент в нём представлены следующие калькуляторы:
          </p>
        </section>
        <section>
          <h2 class="section_title">Калькуляторы веса металла</h2>
          <p><img src="weight.svg" alt="Описание SVG" id="icon">Раздел для расчёта длины и веса металлопроката. На данный момент в нём представлены следующие калькуляторы:
          </p>
        </section>
      </article>
<?php $content = ob_get_clean() ?>
<?php include 'views/layout.php';