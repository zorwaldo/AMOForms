
var element = document.getElementById('phone');
var maskOptions = {
    mask: '+7(000)000-00-00',
    lazy: false
} 
var mask = new IMask(element, maskOptions);

element = document.getElementById('price');
var maskOptions = {
  mask: Number,
  scale: 0,  // Количество десятичных знаков (0 - для целых чисел)
  signed: true,  // Допускать отрицательные значения
  thousandsSeparator: '',  // Разделитель тысячных
  padFractionalZeros: false,  // Добавлять нули к десятичным числам
  normalizeZeros: true,  // Удалять ведущие нули
  radix: ',',  // Разделитель десятичной части
  mapToRadix: ['.']  // Массив символов, которые могут использоваться как разделитель дробной части
};
var mask = IMask(element, maskOptions);
