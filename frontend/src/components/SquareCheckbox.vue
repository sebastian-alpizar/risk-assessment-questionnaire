<template>
  <label class="checkbox-container group">
    <input 
      type="checkbox" 
      class="checkbox-input peer"
      :value="value"
      :checked="isChecked"
      @change="onChange"
      v-bind="$attrs"
    />
    <div class="checkbox-toggle
      after:content-[''] after:absolute after:top-1/2 after:left-1/2 
              after:-translate-x-1/2 after:-translate-y-1/2 
              after:w-5 after:h-5 after:opacity-0 
              after:bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiNmZmZmZmYiIHN0cm9rZS13aWR0aD0iMyIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cG9seWxpbmUgcG9pbnRzPSIyMCA2IDkgMTcgNCAxMiI+PC9wb2x5bGluZT48L3N2Zz4=')] 
              after:bg-contain after:bg-no-repeat
              peer-checked:after:opacity-100 after:transition-opacity after:duration-300">
      <slot name="icon"></slot>
    </div>
    <span v-if="label" class="checkbox-label">
      {{ label }}
    </span>
    <slot v-else></slot>
  </label>
</template>

<script>
export default {
  name: 'SquareCheckbox',
  inheritAttrs: false,
  props: {
    modelValue: {
      type: [Array, Boolean],
      required: true
    },
    value: {
      type: String,
      required: false
    },
    label: {
      type: String,
      default: ''
    }
  },
  emits: ['update:modelValue'],
  computed: {
    isChecked() {
      if (Array.isArray(this.modelValue)) {
        return this.modelValue.includes(this.value)
      }
      return this.modelValue
    }
  },
  methods: {
    onChange(event) {
      const checked = event.target.checked
      let newValue

      if (Array.isArray(this.modelValue)) {
        if (checked) {
          newValue = [...this.modelValue, this.value]
        } else {
          newValue = this.modelValue.filter(v => v !== this.value)
        }
      } else {
        newValue = checked
      }

      this.$emit('update:modelValue', newValue)
    }
  }
}
</script>