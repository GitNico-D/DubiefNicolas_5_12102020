<template>
  <div> 
    <transition name="slideOne"> 
      <div class="menupage d-flex justify-content-center align-items-center"         
        v-if="isNavOpen"
        @click="closeMenu"
        :style="{ '--color': color }"
        >
          <div class="nav-content" v-if="isNavOpen">
            <slot></slot>
          </div>
      </div> 
    </transition>
  </div> 
</template>

<script>
import { menuStore, mutations } from '@/store/menuStore.js'

export default {
  name:"OnePageMenu",
  computed: {
    isNavOpen() {
      return menuStore.isNavOpen;
    }
  },
  methods: {
      closeMenu: mutations.toggleNav
  },
  props: {
    color: String
  },
}
</script>

<style lang="scss" scoped>
  .menupage {
    width: 100%;
    height: 110vh;
    background-color: $dark-gray;
    z-index: 10;
    position: fixed;
    top: 0%;
    left: 0;
    &:before {
      content: "";
      width: 100%;
      height: 5vh;
      background-color: var(--color);
      z-index: 11;
      position: absolute;
      bottom: 0%;
      left: 0;
      filter: blur(3px);
    }
  }
  .slideOne-enter-active, .slideOne-leave-active {
    transition: transform 0.5s cubic-bezier(.77,0,.175,1);
  }
  .slideOne-enter, .slideOne-leave-to {
    transform: translateY(-100%);
    transition: all .5s cubic-bezier(.77,0,.175,1)
  }
</style>