/* eslint-disable */
import help from './help'

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
  },
  arrayFilterWName (array) {
    array = array.filter((value, index, self) =>
      index === self.findIndex((t) => (
        t.workshopName === value.workshopName
      ))
    )
    return array
  },
  arrayFilterWName (array) {
    array = array.filter((value, index, self) =>
      index === self.findIndex((t) => (
        t.workshopName === value.workshopName
      ))
    )
    return array
  },
  arrayFilterDistrict (array) {
    array = array.filter((value, index, self) =>
      index === self.findIndex((t) => (
        t.district === value.district
      ))
    )
    return array
  },
  getQueryVariableForURL (variable, defaultValue, asd='') {
    var querys = !help.isObjectEmpty(asd) ? asd : window.location.href
    if (querys.split('?').length > 1) {
      var query = querys.split('?')[1]
      var vars = query.split('&')
      for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=')
        if (pair[0] === variable) {
          return pair[1]
        }
      }
    }
    return defaultValue
  }
}