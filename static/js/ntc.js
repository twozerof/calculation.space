class NTCCalculator {
    constructor() {
        this.form = document.getElementsByTagName('form');
        this.resultBlock = document.getElementById('calculation-result');
        this.resultBlockB = document.getElementById('b-calculation-result');
        this.resultValue = document.getElementById('result-value');
        this.init();
    }
    
    init() {
        const inputs = this.form.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', this.debounce(this.calculate.bind(this), 300));
            input.addEventListener('change', this.calculate.bind(this));
        });
        
        setTimeout(() => this.calculate(), 100);
        const radioButtons = this.form.querySelectorAll('input[name="convert"]');
        radioButtons.forEach(radio => {
        radio.addEventListener('change', (e) => {
            const placeholder = e.target.getAttribute('data-placeholder');
            const valueInput = this.form.querySelector('#value');
            valueInput.placeholder = placeholder;
        });
    });
    }
    
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
            const response = await fetch('/ntc_thermistor_calculator/handler', {
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
            if (result.error) {
                this.showError(result.error);
                return false;
            }
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
            // температура → Сопротивление
            
            this.resultValue.innerHTML = `<div class="content-item"><span>Сопротивление</span><span class="space"></span><span>${result.resistance} Ом</span></div>
                                        <div class="content-item"><span>Заданная температура</span><span class="space"></span><span>${result.temperature} °C</span></div>
                                        `;
        } else {
            // Сопротивление → температура
            this.resultValue.innerHTML = `<div class="content-item"><span>Температура</span><span class="space"></span><span>${result.temperature} °C</span></div>
                                        <div class="content-item"><span>Заданное сопротивление</span><span class="space"></span><span>${result.resistance} Ом</span></div>
                                        `;
        }
    }
    
    showError(message) {
        this.resultBlock.style.display = 'block';
        this.resultValue.innerHTML = `<span style="color: var(--a-color);font-weight:bold;">${message}</span>`;
    }
    
    hideResult() {
        this.resultBlock.style.display = 'none';
        this.resultBlockB.style.display = 'none';
    }
}

// Инициализация калькулятора когда DOM загружен
document.addEventListener('DOMContentLoaded', function() {
    new NTCCalculator();
});