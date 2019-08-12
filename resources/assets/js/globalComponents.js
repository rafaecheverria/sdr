import fgInput from './components/Inputs/formGroupInput.vue'
import DropDown from './components/Dropdown.vue'
import Card from './components/Cards/Card.vue'
import Button from './components/Button.vue'
import {Input, InputNumber} from 'element-ui'

const GlobalComponents = {
  install (Vue) {
    Vue.component('fg-input', fgInput)
    Vue.component('drop-down', DropDown)
    Vue.component('card', Card)
    Vue.component(Button.name, Button)
    Vue.component(Input.name, Input)
    Vue.component(InputNumber.name, InputNumber)
  }
}

export default GlobalComponents