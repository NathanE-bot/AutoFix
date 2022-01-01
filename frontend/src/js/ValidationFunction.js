/* eslint-disable */

export default {
  convertToRupiah (angka) {
    var rupiah = ''
    if (angka !== null) {
      var angkarev = Math.ceil(angka).toString().split('').reverse().join('')
      for (var i = 0; i < angkarev.length; i++) if (i % 3 === 0) rupiah += angkarev.substr(i, 3) + '.'
      return 'Rp ' + rupiah.split('', rupiah.length - 1).reverse().join('')
    }
    else {
      return ''
    }
  },
  arrayFilter (array) {
    array = array.filter((value, index, self) =>
      index === self.findIndex((t) => (
        t.serviceDetail === value.serviceDetail
      ))
    )
    return array
  }
}