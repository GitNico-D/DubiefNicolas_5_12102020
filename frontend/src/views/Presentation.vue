<template>
  <b-container fluid>
    <Header title="Presentation" color="#485DA6"/>
    <CircleBackground circleColor="#485DA6"/>
    <Transition v-show="showTransition" directionAnimation="left" colorSlideOne="#485DA6"/>
    <b-row class="presentation justify-content-center">
      <b-col cols="10" md="5" xl="3">
        <b-card :img-src="onePresentation.picture" img-top>
          <b-card-title class="text-uppercase">
            <p class="card-title-first">{{ onePresentation.firstName }}</p>
            <p class="card-title-last font-weight-bold">
              {{ onePresentation.lastName }}
            </p>
          </b-card-title>
          <b-card-text>
            <hr class="my-5 card-separator">
            <div class="d-flex flex-wrap justify-content-around my-4">
              <b-link
                v-for="(contact, index) in onePresentation.contacts"
                :key="contact.id"
                :href="(contact.title == 'Mail') ? ('mailto:' + contact.link) : (contact.link)"
                :style="[index % 2 ? (buttonStyleOne) : (buttonStyleTwo), {'--url-icon': 'url(' + contact.icon + ')'}]"
                class="btn m-1 p-2"
                >
                {{ contact.title }}
              </b-link>
              <b-link 
                href="http://portfolio/img/cv/cv.pdf" 
                class="btn m-1 p-2"
                :style="[buttonStyleOne, {'--url-icon': 'url(http://portfolio/img/cv/pdf.png)'}]"
                >
                CV
              </b-link>
            </div>
          </b-card-text>
        </b-card>
        <div class="card-border-back"></div>
      </b-col>
      <b-col cols="12" md="6" xl="5" class="presentation-text">
        <div>
          <h5 class="text-right text-uppercase">
            {{ onePresentation.titleFirstText }}
          </h5>
          <p class="presentation-text-first text-justify">
            {{ onePresentation.firstText }}
          </p>
          <div class="presentation-text-separator"></div>
          <h5 class="text-left text-uppercase pt-4">
            {{ onePresentation.titleSecondText }}
          </h5>
          <p class="presentation-text-second text-justify">
            {{ onePresentation.secondText }}
          </p>
          <div class="presentation-text-separator"></div>
          <h5 class="text-right text-uppercase pt-4">
            {{ onePresentation.titleThirdText }}
          </h5>
          <p class="presentation-text-third text-justify">
            {{ onePresentation.thirdText }}
          </p>
        </div>
      </b-col>
    </b-row>
    <b-row class="footer justify-content-center align-items-center">
      <HomePageLink
        action="Retour"
        url="/"
        direction="animated-arrowRtl"
        class="link link-right"
        textColor="#485DA6"
        hoverColor="#485DA6"
      />
    </b-row>
  </b-container>
</template>

<script>
import Header from "@/components/Header.vue";
import HomePageLink from "@/components/HomePageLink.vue";
import Transition from "@/components/Transition.vue";
import CircleBackground from '@/components/CircleBackground.vue'
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Header,
    HomePageLink,
    Transition,
    CircleBackground
  },
  data() {
    return {
      showTransition: true,
      logoIcon: String,
      buttonStyleOne: {
        '--color-one': '#485DA6', 
        '--color-two': '#FF9C66',
      },
      buttonStyleTwo: {
        '--color-one': '#FF9C66', 
        '--color-two': '#485DA6'
      }
    }
  },
  computed: {
    ...mapGetters(["onePresentation"])
  },
  methods: {
    ...mapActions(["getPresentation"]),
    actionTransition() {
      this.showTransition = true;
      setTimeout(() => {
        this.showTransition = false;
      }, 1300);
    }
  },
  created() {
    setTimeout(() => {
      this.showTransition = false;
    }, 1300);
  },
  mounted() {
    this.$store.dispatch("getPresentation")
  }
};
</script>

<style lang="scss" scoped>
.container-fluid {
  background-color: $dark-gray;
  perspective: 1000px;
  position: relative;
  min-height: 100vh;
  overflow: hidden;
}
.btn {
  color: $white;
  border: 2px solid var(--color-one);
  box-shadow: 0 0 5px var(--color-one);
  transition: transform 0.2s ease;
  position: relative;
  &:before {
    content: "";
    position: absolute;
    transition: transform 0.2s ease;
    transform: rotate(0deg);
  }
  &:after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -100%;
    border-radius: 25%;
    width: 100%;
    height: 100%;
    background: var(--color-one);
    transform: perspective(1.5em) rotateX(40deg) scale(1, 0.35);
    filter: blur(1em);
    opacity: 0.7;
  }
  &:hover {
    color: var(--color-two);
    background-color: var(--color-one);
    box-shadow: 0 0 10px var(--color-two);
    transform: scale(1.2);
    transition: transform 0.2s ease;
    &:before {
      content: "";
      transition: transform 0.2s ease;
      position: absolute;
      background: var(--url-icon) no-repeat;
      top: -30%;
      left: 55%;
      transform: rotate(12deg) scale(1.2);
      width: 100%;
      height: 100%;
    }
  }
}
.presentation {
  padding-top: 10rem;
  height: unset;
  .card {
    animation: text-focus-in 0.7s cubic-bezier(0.55, 0.085, 0.68, 0.53) 1s both;
    border: 4px solid rgba(72, 93, 166, 0.7);
    @include box_shadow(0px, 0px, 15px, $blue);
    background: transparent;
    &-title {
      font-family: "MontSerrat", sans-serif;
      font-size: 2.5rem;
      &-first {
        color: $white;
        @include text_shadow(2px, 3px, 3px, $blue);
      }
      &-last {
        color: $white;
        @include text_shadow(2px, 3px, 2px, $orange);
      }
    }
    &-body {
      margin-top: 5rem;
    }
    &-text {
      font-family: "Oswald", sans-serif;
      color: $blue;
      animation: text-focus-in 0.7s cubic-bezier(0.55, 0.085, 0.68, 0.53) 1s
        both;
    }
    &-img-top {
      position: absolute;
      animation: text-focus-in 0.7s cubic-bezier(0.55, 0.085, 0.68, 0.53) 1s
        both;
      @include box_shadow(0px, 0px, 15px, $blue);
      filter: none;
    }
    &-separator {
      background: $orange;
      @include box_shadow(0px, 0px, 5px, $orange);
      width: 60%;
    }
  }
  &-text {
    color: $white;
    font-family: "Montserrat", sans-serif;
    line-height: 1.6rem;
    h5 {
      animation: text-focus-in 0.7s cubic-bezier(0.55, 0.085, 0.68, 0.53) 1s
        both;
    }
    &-first, &-third {
      border-right: 1px solid $orange;
      padding: 1rem;
      animation: slide-in-blurred-right 0.6s cubic-bezier(0.23, 1, 0.32, 1) 1s
        both;
    }
    &-second {
      border-left: 1px solid $orange;
      padding: 1rem;
      animation: slide-in-blurred-left 0.6s cubic-bezier(0.23, 1, 0.32, 1) 1.3s
        both;
    }
    &-separator {
      width: 50%;
      margin: auto;
      height: 4px;
      background-color: $blue;
      box-shadow: 0px 0px 20px $blue;
    }
  }
}
.footer {
  height: 8vh;
}
@keyframes tilt-in-fwd-tl {
  0% {
    transform: rotateY(-20deg) rotateX(35deg) translate(-300px, -300px)
      skew(35deg, -10deg);
    opacity: 0;
  }
  100% {
    transform: rotateY(0) rotateX(0deg) translate(-40%, -60%) skew(0deg, 0deg);
    opacity: 1;
  }
}
@keyframes tracking-in-expand-fwd {
  0% {
    letter-spacing: -0.5em;
    transform: translateZ(-700px);
    opacity: 0;
  }
  40% {
    opacity: 0.6;
  }
  100% {
    transform: translateZ(0);
    opacity: 1;
  }
}
@keyframes text-focus-in {
  0% {
    filter: blur(12px);
    opacity: 0;
  }
  100% {
    filter: blur(0px);
    opacity: 1;
  }
}
@keyframes slide-in-blurred-right {
  0% {
    transform: translateX(1000px) scaleX(2.5) scaleY(0.2);
    transform-origin: 0% 50%;
    filter: blur(40px);
    opacity: 0;
  }
  100% {
    transform: translateX(0) scaleY(1) scaleX(1);
    transform-origin: 50% 50%;
    filter: blur(0);
    opacity: 1;
  }
}
@keyframes slide-in-blurred-left {
  0% {
    transform: translateX(-1000px) scaleX(2.5) scaleY(0.2);
    transform-origin: 100% 50%;
    filter: blur(40px);
    opacity: 0;
  }
  100% {
    transform: translateX(0) scaleY(1) scaleX(1);
    transform-origin: 50% 50%;
    filter: blur(0);
    opacity: 1;
  }
}
@media (min-width: 320px) {
  .presentation {
    .card {
      transform: none;
      &-img-top {
        transform: translate(35%, -50%);
        width: 60%;
      }
      &-title {
        font-size: 1.4rem;
      }
      &-border-back {
        height: 100%;
      }
    }
    &-text {
      padding-top: 3rem;
      font-size: 0.8rem;
      &-first, &-third {
        margin: 2.5rem 0rem 1.5rem 0;
      }
      &-second {
        margin: 2.5rem 0 1.5rem 0rem;
      }
    }
  }
  .footer {
    .link {
      transform: scale(0.7);
    }
  }
}
@media (min-width: 576px) {
  .presentation {
    .card {
      &-img-top {
        transform: translate(35%, -50%);
      }
      &-title {
        font-size: 1.5rem;
        padding-top: 3rem;
      }
    }
    &-text {
      padding-left: 1.5rem;
      
    }
  }
}
@media (min-width: 768px) {
  .presentation {
    .card {
      transform: perspective(1000px) rotateX(0deg) rotateY(10deg);
      &-title {
        font-size: 2rem;
        padding-top: 1.5rem;
      }
      &-border-back {
        height: 36%;
      }
    }
    &-text {
      font-size: 0.8rem;
    }
  }
}
@media (min-width: 992px) {
  .presentation {
    .card {
      &-title {
        padding-top: 1.5rem;
      }
    }
    &-text {
      font-size: 0.9rem;
      &-first, &-third {
        margin: 2.5rem 3rem 1.5rem 0;
      }
      &-second {
        margin: 2.5rem 0 1.5rem 3rem;
      }
    }
  }
}
@media (min-width: 1200px) {
  .presentation {
    .card {
      &-img-top {
        transform: translate(-40%, -60%);
        width: 50%;
      }
      &-title {
        font-size: 2.5rem;
        padding-top: unset;
      }
      &-text {
        font-size: 1.2rem;
      }
      &-border-back {
        height: 50%;
      }
    }
    &-text {
      font-size: 1.1rem;
    }
  }
}
</style>
