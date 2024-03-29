<template>
  <b-container fluid>
    <div class="position-absolute div-button">
      <b-link
        v-if="loggedIn"
        to="/admin"
        type="button"
        class="btn btn-admin"
        v-b-popover.hover.leftbottom="'Vers page administrateur'"
      >
        <font-awesome-icon icon="user-shield" />
      </b-link>
      <b-link
        to="/login"
        v-if="!loggedIn"
        type="button"
        class="btn btn-login"
        v-b-popover.hover.rightbottom="'Connexion'"
      >
        <font-awesome-icon icon="sign-out-alt" />
      </b-link>
      <b-button
        to=""
        v-if="loggedIn"
        @click.prevent="logOut"
        class="btn btn-logout"
        v-b-popover.hover.rightbottom="'Déconnexion'"
      >
        <font-awesome-icon icon="sign-in-alt" />
      </b-button>
    </div>
    <b-row>
      <div class="circle_box">
        <div class="circle circle-blue"></div>
        <div class="circle circle-purple"></div>
        <div class="circle circle-green">
          <div class="circle circle-littleGreen"></div>
        </div>
        <div class="circle circle-purple2"></div>
        <div class="circle circle-green2"></div>
        <div class="circle circle-blue2"></div>
      </div>
      <div class="title">
        <h2><span>Nicolas</span>,</h2>
        <h1>Développeur Web</h1>
      </div>
    </b-row>
    <Transition v-show="showTransition" directionAnimation="up" colorSlideOne="#36C486"/>
    <HomePageLink
      @click="actionTransition"
      action="Projets"
      url="/projects"
      direction="animated-arrowRtl"
      class="link link-right"
      textColor="#36C486"
      hoverColor="#6d327c"
    />
    <HomePageLink
      action="Presentation"
      url="/presentation"
      direction="animated-arrowLtr"
      class="link link-left"
      textColor="#36C486"
      hoverColor="#485DA6"
    />
    <HomePageLink
      action="Parcours"
      url="/career"
      direction="animated-arrowRtl"
      class="link link-top"
      textColor="#36C486"
      hoverColor="#00a1ba"
    />
    <HomePageLink
      action="Compétences"
      url="/skills"
      direction="animated-arrowRtl"
      class="link link-bottom"
      textColor="#36C486"
      hoverColor="#36C486"
    />
  </b-container>
</template>

<script>
import HomePageLink from "@/components/HomePageLink.vue";
import Transition from "@/components/Transition.vue";

export default {
  name: "background",
  components: {
    HomePageLink,
    Transition
  },
  data() {
    return {
      showTransition: true
    };
  },
  methods: {
    actionTransition() {
      this.showTransition = true;
      setTimeout(() => {
        this.showTransition = false;
      }, 1300);
    },
    logOut() {
      this.$store.dispatch("auth/logout");
    }
  },
  computed: {
    //Verifying if a user loggedIn 
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    }
  },
  created() {
    setTimeout(() => {
      this.showTransition = false;
    }, 1300);
  }
};
</script>

<style lang="scss" scoped>
.container-fluid {
  background-color: $dark-gray;
  position: relative;
  perspective: 1000px;
  overflow: hidden;
  .row {
    height: 100vh;
    .title {
      @include customFont;
      position: absolute;
      top: 45%;
      left: 24%;
      color: $white !important;
      line-height: 50px;
      text-align: left;
      &:hover {
        cursor: default;
      }
      span {
        color: $green;
        @include text_shadow(0px, 0px, 5px);
      }
      h1 {
        @include customFont;
        letter-spacing: 0.5rem;
        @include text_shadow(2px, 3px, 2px);
        color: $white !important;
        margin-left: 2rem;
        animation: slideH1 1s ease-in-out 0.5s;
        transition: transform 0.5s cubic-bezier(0.03, 0.92, 0.87, 1.46);
        &:hover {
          transform: translate3d(0px, 0px, 100px);
        }
      }
      h2 {
        font-size: 2.5rem;
        animation: slideH2 1.25s ease-in-out 0.5s;
        transition: transform 0.5s cubic-bezier(0.03, 0.92, 0.87, 1.46);
        &:hover {
          transform: translate3d(0px, 0px, 100px);
        }
      }
    }
  }
  .btn {
    &-admin {
      color: $green;
      background-color: transparent;
      &:hover {
        color: $white !important;
        background-color: $green !important;
        box-shadow: 0 0 10px $white !important;
      }
    }
    &-login {
      color: $green;
      background-color: transparent;
      &:hover {
        color: $white !important;
        background-color: $green !important;
        box-shadow: 0 0 10px $white !important;
      }
    }
    &-logout {
      color: $red;
      border: none;
      background-color: transparent;
      &:hover {
        color: $white !important;
        background-color: $red !important;
        box-shadow: 0 0 10px $white !important;
      }
    }
  }
}
@keyframes slideH1 {
  0% {
    transform: translateY(100px);
  }
  50% {
    transform: translateY(-40px);
  }
  100% {
    transform: translateY(0px);
  }
}
@keyframes slideH2 {
  0% {
    transform: translateY(100px);
  }
  50% {
    transform: translateY(-60px);
  }
  100% {
    transform: translateY(0px);
  }
}
@keyframes slideBtn {
  0% {
    transform: translateY(80px);
  }
  50% {
    transform: translateY(-30px);
  }
  100% {
    transform: translateY(0px);
  }
}
@keyframes opacityIn {
  0% {
    opacity: 0;
  }
  50% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
.circle_box {
  height: 100vh;
  width: 100vw;
}
.circle {
  position: absolute;
  width: 100%;
  border-radius: 100%;
  animation: circles 9.5s linear infinite -2s;
  &-blue {
    background-color: $light-blue;
    width: 10vw;
    height: 10vw;
    top: 75%;
    left: 50%;
    transform-style: preserve-3d;
    animation-duration: 15s;
    filter: blur(7px);
  }
  &-purple {
    background-color: $purple;
    border-radius: 100%;
    width: 30vw;
    height: 30vw;
    top: 20%;
    left: -20%;
    @include box_shadow(0px, 0px, 100px, $purple);
    transform-style: preserve-3d;
    animation-duration: 6s;
    filter: blur(3px);
  }
  &-green {
    border: 25px solid $green;
    width: 15vw;
    height: 15vw;
    top: 55%;
    right: 5%;
    transform-style: preserve-3d;
    @include box_shadow(0px, 0px, 50px);
    animation-duration: 25s;
    filter: blur(10px);
  }
  &-littleGreen {
    background-color: $green;
    width: 2vw;
    height: 2vw;
    top: 25%;
    left: 70%;
    transform-style: preserve-3d;
    animation-duration: 5s;
  }
  &-purple2 {
    border: 25px solid $blue;
    width: 10vw;
    height: 10vw;
    top: 60%;
    left: 20%;
    z-index: 30;
    transform-style: preserve-3d;
    animation-duration: 8s;
    filter: blur(3px);
  }
  &-green2 {
    background-color: $white;
    width: 3vw;
    height: 3vw;
    top: 30%;
    left: 37%;
    @include box_shadow(0px, 0px, 50px, $white);
  }
  &-blue2 {
    background-color: $purple;
    width: 8vw;
    height: 8vw;
    top: 80%;
    right: 20%;
    @include box_shadow(0px, 0px, 75px, $purple);
    transform-style: preserve-3d;
    filter: blur(1px);
  }
  @keyframes circles {
    from {
      transform: translateY(450%);
    }
    to {
      transform: translateY(calc(-100vh + -100%)) translateX(75%);
    }
  }
}

@media (min-width: 320px) {
  .container-fluid .row {
    .title {
      left: 20%;
      h1 {
        font-size: 1.5rem;
        margin-left: 0;
        width: 80%;
      }
      h2 {
        font-size: 1rem;
      }
      .btn {
        margin: 1rem 0 0 4rem;
        transform: scale(0.7);
      }
    }
  }
  .link {
    position: absolute;
    animation: 2s ease-in-out opacityIn;
    &-left {
      transform: translateX(-20%) scale(0.5);
      left: 1%;
      top: 2%;
    }
    &-right {
      transform: translateX(20%) scale(0.5);
      right: 2%;
      bottom: 2%;
    }
    &-top {
      transform-style: preserve-3d;
      transform: translateX(40%) rotateZ(-90deg) scale(0.5);
      right: 1%;
      top: 12%;
    }
    &-bottom {
      transform-style: preserve-3d;
      transform: translatex(-40%) rotateZ(90deg) scale(0.5);
      left: 0;
      bottom: 14%;
    }
  }
  .div-button {
    left: 50%;
    bottom: 44%;
    transform: translate(0%, 100%);
  }
}
@media (min-width: 576px) {
  .container-fluid .row {
    .title {
      left: 16%;
      h1 {
        font-size: 2rem;
        margin-left: 0.5rem;
        width: 100%;
      }
      h2 {
        font-size: 1.3rem;
      }
      .btn {
        margin: 2rem 0 0 15rem;
        transform: scale(0.9);
      }
    }
  }
  .link {
    &-left {
      transform: scale(0.6);
    }
    &-right {
      transform: scale(0.6);
    }
    &-top {
      transform: translateX(35%) rotateZ(-90deg) scale(0.6);
      right: 0;
      top: 12%;
    }
    &-bottom {
      transform: translatex(-35%) rotateZ(90deg) scale(0.6);
      left: 0;
      bottom: 14%;
    }
  }
  .div-button {
    left: 50%;
    top: 0;
    transform: translateX(-50%);
  }
}
@media (min-width: 768px) {
  .container-fluid .row {
    .title {
      h1 {
        font-size: 2.5rem;
        margin-left: 1rem;
      }
      h2 {
        font-size: 1.8rem;
      }
      .btn {
        margin: 2rem 0 0 18rem;
        transform: scale(1);
      }
    }
  }
  .link {
    &-left {
      transform: scale(0.9);
    }
    &-right {
      transform: scale(0.9);
    }
    &-top {
      transform: translateX(25%) rotateZ(-90deg) scale(0.9);
      right: 0;
      top: 12%;
    }
    &-bottom {
      transform: translatex(-25%) rotateZ(90deg) scale(0.9);
      left: 0;
      bottom: 14%;
    }
  }
}
@media (orientation: landscape) and (max-width: 992px) {
  .link {
    &-left {
      transform: scale(0.7);
      left: 3%;
      top: 4%;
    }
    &-right {
      transform: scale(0.7);
      right: 3%;
      bottom: 4%;
    }
    &-top {
      transform: translateX(25%) rotateZ(-90deg) scale(0.7);
      right: -2%;
      top: 18%;
    }
    &-bottom {
      transform: translatex(-25%) rotateZ(90deg) scale(0.7);
      left: -3%;
      bottom: 22%;
    }
  }
}
@media (min-width: 992px) {
  .container-fluid .row {
    .title {
      left: 21%;
      left: 24%;
      h1 {
        font-size: 3rem;
        margin-left: 1.5rem;
      }
      h2 {
        font-size: 2.2rem;
      }
      .btn {
        margin: 2rem 0 0 20rem;
      }
    }
  }
  .link {
    &-left {
      left: 3%;
      top: 4%;
    }
    &-right {
      right: 3%;
      bottom: 4%;
    }
    &-top {
      transform: translateX(25%) rotateZ(-90deg);
      right: 0;
      top: 14%;
    }
    &-bottom {
      transform: translatex(-25%) rotateZ(90deg);
      left: 0;
      bottom: 17%;
    }
  }
}
@media (min-width: 1200px) {
  .container-fluid .row {
    .title {
      left: 20%;
      h1 {
        font-size: 4rem;
        margin-left: 2rem;
      }
      h2 {
        font-size: 2.5rem;
      }
      .btn {
        margin: 2rem 0 0 30rem;
      }
    }
  }
  .link {
    &-left {
      left: 5%;
      top: 5%;
    }
    &-right {
      right: 4%;
      bottom: 5%;
    }
    &-top {
      transform: rotateZ(-90deg);
      top: 13%;
    }
    &-bottom {
      transform: rotateZ(90deg);
      left: 0;
      bottom: 16%;
    }
  }
}
</style>
