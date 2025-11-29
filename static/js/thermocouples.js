class ThermocoupleCalculator {
    constructor() {
        this.form = document.getElementById('thermocouple-calculator');
        this.resultBlock = document.getElementById('calculation-result');
        this.resultValue = document.getElementById('result-value');
        
        this.init();
    }
    
    init() {
        // Убираем кнопку отправки
        /*const submitButton = this.form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.style.display = 'none';
        }
        */
        // Добавляем обработчики событий на все поля ввода
        const inputs = this.form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', this.debounce(this.calculate.bind(this), 300));
            input.addEventListener('change', this.calculate.bind(this));
        });
        
        // Первоначальный расчёт если есть значения
        setTimeout(() => this.calculate(), 100);
        // Добавьте этот код в метод init()
const radioButtons = this.form.querySelectorAll('input[name="convert"]');
radioButtons.forEach(radio => {
    radio.addEventListener('change', (e) => {
        const placeholder = e.target.getAttribute('data-placeholder');
        const valueInput = this.form.querySelector('#value');
        valueInput.placeholder = placeholder;
    });
});
    }
    
    // Функция для предотвращения слишком частых запросов
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    async calculate() {
        // Собираем данные формы
        const formData = new FormData(this.form);
        const data = {
            type: formData.get('type'),
            convert: formData.get('convert'),
            value: formData.get('value'),
            compensation: formData.get('compensation')
        };
        
        // Проверяем, что все необходимые поля заполнены
        if (!this.validateData(data)) {
            this.hideResult();
            return;
        }
        
        try {
            const response = await fetch('/thermocouple_calculator/handler', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            if (!response.ok) {
                throw new Error('Ошибка сервера');
            }
            
            const result = await response.json();
            
            // Отображаем результат
            this.showResult(result);
            
        } catch (error) {
            console.error('Ошибка:', error);
            this.showError('Произошла ошибка при расчёте');
        }
    }
    
    validateData(data) {
        // Проверяем, что значение параметра заполнено
        if (!data.value || data.value.trim() === '') {
            return false;
        }
        
        // Проверяем, что тип термопары выбран
        if (!data.type) {
            return false;
        }
        
        return true;
    }
    
    showResult(result) {
        this.resultBlock.style.display = 'block';
        // Форматируем результат в зависимости от направления расчёта
        const convertDirection = document.querySelector('input[name="convert"]:checked').value;
        
        if (convertDirection === '0') {
            // температура → термо-ЭДС
            
            this.resultValue.innerHTML = `<div class="content-item"><span>Термо-ЭДС</span><span class="space"></span><span>${result.emf} мВ</span></div>
                                        <div class="content-item"><span>Заданная температура</span><span class="space"></span><span>${result.temperature} °C</span></div>
                                        <div class="content-item">${result.delta}</div>
                                        `;
        } else {
            // термо-ЭДС → температура
            this.resultValue.innerHTML = `<div class="content-item"><span>Температура</span><span class="space"></span><span>${result.temperature} °C</span></div>
                                        <div class="content-item"><span>Термо-ЭДС</span><span class="space"></span><span>${result.emf} мВ</span></div>
                                        <div class="content-item">${result.delta}</div>
                                        `;
        }
    }
    
    showError(message) {
        this.resultBlock.style.display = 'block';
        this.resultValue.innerHTML = `<span style="color: var(--a-color);font-weight:bold;">${message}</span>`;
    }
    
    hideResult() {
        this.resultBlock.style.display = 'none';
    }
}

// Инициализация калькулятора когда DOM загружен
document.addEventListener('DOMContentLoaded', function() {
    new ThermocoupleCalculator();
});