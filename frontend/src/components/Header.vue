<template>

  <b-row class="justify-content-center flex-column align-items-center">
    <MenuIcon :color="color"/>
    <OnePageMenu :color="color">
      <b-navbar :style="{ '--color': color }" toggleable="sm" class="navpage-content ">
        <b-navbar-nav class="py-3 flex-column justify-content-center" :style="{ '--color': color }">
          <router-link to="/" v-b-popover.hover.leftbottom="'Accueil'">
            <font-awesome-icon icon="home" />
          </router-link>
          <router-link to="/presentation">Présentation</router-link>
          <router-link to="/projects">Projets</router-link>
          <router-link to="/skills">Compétences</router-link>
          <router-link to="/career">Carrières</router-link>
          <b-link
            v-if="loggedIn"
            to="/admin"
            @click="reloadPage"
            v-b-popover.hover.bottom="'Vers page administrateur'"
          >
            <font-awesome-icon icon="user-shield" />
          </b-link>
          <router-link
            to="/login"
            v-if="!loggedIn"
            v-b-popover.hover.bottom="'Connexion'"
          >
            <font-awesome-icon icon="sign-out-alt" /> 
          </router-link>
          <b-link
            to=""
            v-if="loggedIn"
            @click.prevent="logOut"
            v-b-popover.hover.bottom="'Déconnexion'"
          >
            <font-awesome-icon icon="sign-in-alt" />
          </b-link>
        </b-navbar-nav>    
      </b-navbar>
    </OnePageMenu>
    <h1 :style="{ '--color': color }">{{ title }}</h1>    
  </b-row>

</template>

<script>
import OnePageMenu from './OnePageMenu.vue'
import MenuIcon from './MenuIcon.vue'

export default {
  name: "Header",
  components: {
    OnePageMenu,
    MenuIcon
  },
  props: {
    color: String,
    title: String
  },
  data() {
    return {
      isActive: false
    }
  },
  methods: {
    logOut() {
      this.$store.dispatch("auth/logout");
      this.$router.push("/login");
    },
    reloadPage() {
      document.location.reload(true);
    },
    showMenu() {
      this.isActive = !this.isActive;
    }
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    }
  }
};
</script>

<style lang="scss" scoped>
.col {
  padding: 0;
}
.row {
  .navbar {
    width: 100%;
    &-nav {
      margin: auto;
      z-index: 2;
      a {
        position: relative;
        font-family: "Oswald", sans-serif;
        color: $white;
        text-transform: uppercase;
        font-size: 3rem;
        transition: ease-out 0.2s;
        animation: slide-in-bottom 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) 0.3s both;
        @for $i from 0 through 7 {
          &:nth-child(#{$i}) {
            animation-delay: $i * 0.2s;
          }
        }
        &::after {
          position: absolute;
          content: " ";
          top: 100%;
          left: 0;
          width: 100%;
          height: 3px;
          background: var(--color);
          transform: scaleX(0);
          transform-origin: right;
          transition: transform 0.5s;
        }
        &:hover::after {
          transform: scaleX(1);
          transform-origin: left;
        }
        &:hover {
          color: var(--color);
        }
      }
      .router-link-exact-active {
        color: var(--color);
        &:hover {
          color: $white;
        }
      }
      span {
        color: var(--color);
        font-weight: bold;
      }
    }
  }
  h1 {
    @include customFont;
    @include text-shadow (0px, 0px, 5px, var(--color));
    color: var(--color);
    text-transform: uppercase;
    animation: tracking-in-expand 0.7s cubic-bezier(0.215, 0.61, 0.355, 1) 1s
      both;
  }
  .menu {
    &-icon {
      width: 2rem;
      height: 2rem;
      background-color: transparent;
      border: 1px solid $green;
      cursor: pointer;
      position: relative;
      transition: all 0.3s ease-in-out;
      @include box_shadow;
      &:hover, &:active {
        border-radius: 50%;
        background-color: $green;
        @include box_shadow;
        .menu {
          &-line {
            &-top {
              @include box_shadow;
              border: 1px solid $green;
              transform: translate(-100%, -50%);
            }
            &-bottom {
              @include box_shadow;
              border: 1px solid $green;
              transform: translate(0%, 50%);
            }
          }
        }
      }
    }
    &-line {
      &-top {
        transition: all 0.3s ease-in-out;
        position: absolute;
        top: 0;
        transform: translate(-50%, -50%);
        border: 1px solid transparent;
        width: 100%;
      }
      &-bottom {
        transition: all 0.3s ease-in-out;
        position: absolute;
        bottom: 0;
        transform: translate(-50%, 50%);
        border: 1px solid transparent;
        width: 100%;
      }
    }
  }
  @keyframes tracking-in-expand {
    0% {
      letter-spacing: -0.5em;
      opacity: 0;
    }
    40% {
      opacity: 0.6;
    }
    100% {
      opacity: 1;
    }
  }
  @keyframes slide-in-bottom {
    0% {
      -webkit-transform: translateY(1000px);
              transform: translateY(1000px);
        opacity: 0;
    }
    100% {
      -webkit-transform: translateY(0);
              transform: translateY(0);
      opacity: 1;
    }
  }
}
@media (min-width: 320px) {
  .row {
    h1 {
      font-size: 1.8rem !important;
      letter-spacing: 0.2rem!important;
    }
    .navbar {
      &-nav {
        a {
          margin-bottom: 1rem;
          font-size: 1.5rem;
        }
      }
    }
  }
}
@media (min-width: 576px) {
  .row {
    h1 {
      font-size: 2.2rem !important;
      letter-spacing: 0.5em!important;
    }
    .navbar {
      &-nav {
        span {
          display: block;
        }
      }
    }
  }
}
@media (min-width: 768px) {
  .row {
    height: 25vh;
    h1 {
      font-size: 2.8rem !important;
    }
    .navbar {
      a {
        margin-bottom: 2rem;
        font-size: 3rem;
      }
    }
  }
}
</style>
