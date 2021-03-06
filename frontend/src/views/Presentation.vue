<template>
    <b-container fluid>
        <Header title="Presentation" color="#485DA6" class="header"/>
        <BackgroundPage circleColor="#485DA6"/>
        <Transition v-show="showTransition" directionAnimation="left"/>
        <b-row class="presentation justify-content-center"
            v-for="presentation in presentations" 
            :key="presentation.id"
            >
            <b-col cols="10" md="5" xl="3">
                <b-card :img-src="require('../assets/img-test-1.jpg')" img-top>
                    <b-card-title class="text-uppercase">  
                        <span class="card-title-first">{{ presentation.lastName }}</span> <span class="card-title-last font-weight-bold">{{ presentation.firstName }}</span>
                    </b-card-title>
                    <hr>
                    <b-card-text>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        <div class="d-flex flex-wrap justify-content-around my-4">
                            <Button 
                                v-for="(contact, index) in presentation.contacts" 
                                :key="contact.id"
                                :name="contact.title" 
                                :href="contact.link" 
                                :logoIcon="contact.icon"
                                :colorOne="(index % 2) ? colorOne = '#485DA6' : colorOne= '#FF9C66'" 
                                :colorTwo="(index % 2) ? colorOne = '#FF9C66' : colorTwo = '#485DA6'" 
                                />
                        </div>
                    </b-card-text>
                </b-card>
                <div class="card-border-back"></div>
            </b-col>
            <b-col cols="12" md="6" xl="5" class="presentation-text">
                <div>
                    <h5 class="text-right text-uppercase">{{ presentation.titleFirstText }}</h5>
                    <p class="presentation-text-first text-justify">
                        {{ presentation.firstText }}
                    </p>
                    <div class="presentation-text-separator"></div>
                    <h5 class="text-left text-uppercase pt-4">{{ presentation.titleSecondText }}</h5>
                    <p class="presentation-text-second text-justify">
                        {{ presentation.secondText }}
                    </p>
                    <div class="presentation-text-separator"></div>
                    <h5 class="text-right text-uppercase pt-4">{{ presentation.titleThirdText }}</h5>
                    <p class="presentation-text-third text-justify">
                        {{ presentation.thirdText }}
                    </p>
                </div>
            </b-col>
        </b-row>
        <b-row class="bottom position-relative">
            <HomePageLink action="Retour" url="/" direction="animated-arrowRtl" class="link link-right" textColor="#485DA6"/>
        </b-row> 
    </b-container>
</template>

<script>
import BackgroundPage from '@/components/BackgroundPage.vue'
import Header from '@/components/Header.vue'
import HomePageLink from '@/components/HomePageLink.vue'
import Transition from "@/components/Transition.vue"
import Button from '@/components/Button.vue'
import errorRedirection from '@/services/errorRedirection'

export default {
    components: {
        BackgroundPage,
        Header,
        HomePageLink,
        Transition,
        Button
    },
    data() {
        return {
            showTransition: true,
            presentations: null
        }
    },
    methods: {
        actionTransition () {
            this.showTransition = true;
            setTimeout(() => {
                this.showTransition = false;
            },1300);
        }
    },
    created() {
        setTimeout(() => {
            this.showTransition = false;
        },1300);
        this.axios.get(process.env.VUE_APP_API_URL + '/presentations', {
            headers: {
                "Content-Type": "application/json"
            },
        })  
        .then(response => { 
            this.presentations = response.data
            return Promise.resolve(response.data); 
            })            
        .catch(error => { 
            console.log(error);
            errorRedirection(error);
        });
    }
}
</script>

<style lang="scss" scoped>
.header {
    height: 12vh;
}
.presentation {
    padding-top: 14rem;
    height: unset;
    .card {
        animation: text-focus-in 0.7s cubic-bezier(0.550, 0.085, 0.680, 0.530) 1s both;
        &-title {
            font-family: "MontSerrat", sans-serif;
            font-size:2.5rem;
            &-first {
                color: $blue;
                margin-right: 5rem;
            }
            &-last {
                color: $orange;
                margin-left: 5rem;
            }
        }
        &-body {            
            margin-top: 5rem;
        }
        &-border-back {
            position: absolute;
            content: "";
            border: 8px solid rgba(72, 93, 166, 0.2);
            top: 5%;
            left: 5%;
            width: 95%;
            @include box_shadow(0px, 0px, 15px, $blue);
            z-index: -1;
            animation: text-focus-in 0.7s cubic-bezier(0.550, 0.085, 0.680, 0.530) 1s both;
        }
        &-text {
            font-family: "Oswald", sans-serif;
            color: $blue;
            animation: text-focus-in 0.7s cubic-bezier(0.550, 0.085, 0.680, 0.530) 1s both;
        }
        &-img-top {
            position: absolute;
            animation: text-focus-in 0.7s cubic-bezier(0.550, 0.085, 0.680, 0.530) 1s both;
            @include box_shadow(0px, 0px, 15px, $blue);
        }
    }
    &-text {
        color: $white;
        font-family: "Oswald", sans-serif;
        h5 {
            animation: text-focus-in 0.7s cubic-bezier(0.550, 0.085, 0.680, 0.530) 1s both;
        }
        &-first {
            border-right: 1px solid $orange;
            padding: 1rem;
            margin: 2.5rem 5rem 2.5rem 0;
            animation: slide-in-blurred-right 0.6s cubic-bezier(0.230, 1.000, 0.320, 1.000) 1s both;
        }
        &-second {
            border-left: 1px solid $orange;
            padding: 1rem;
            margin: 2.5rem 0 2.5rem 5rem;
            animation: slide-in-blurred-left 0.6s cubic-bezier(0.230, 1.000, 0.320, 1.000) 1.3s both;
        }
        &-third {
            border-right: 1px solid $orange;
            padding: 1rem;
            margin: 2.5rem 5rem 5rem 0;
            animation: slide-in-blurred-right 0.6s cubic-bezier(0.230, 1.000, 0.320, 1.000) 1.5s both;
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
.bottom {
    height: 8vh;
    &-right {
        position: absolute;
    }
}
@keyframes tilt-in-fwd-tl {
    0% {
        transform: rotateY(-20deg) rotateX(35deg) translate(-300px, -300px) skew(35deg, -10deg);
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
            &-img-top {
                transform: translate(10%, -30%);
                width: 80%;
            }
            &-title {
                font-size: 1.5rem;
                padding-top: 1rem;
            }
            &-border-back {
                height: 100%;
            }
        }
        &-text {
            padding-top: 3rem;
        }
    }
    .bottom {
        .link {
            &-right {
                position: absolute;
                transform: translateX(5%) scale(0.7);
                right: 50%;
                bottom: 50%;
            }
        }
    }
}
@media (min-width: 576px) {
    .presentation {
        .card {
            &-img-top {
                transform: translate(10%, -50%);
            }
            &-title {
                font-size: 1.5rem;
                padding-top: 1.5rem;
                &-first, &-last {
                    margin: unset;
                }
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
            &-title {
                font-size: 2rem;
                padding-top: unset;
            }
            &-border-back {
                height: 31%;
            }
        }
    }
}
@media (min-width: 1200px) {
    .presentation {
        .card {
            &-img-top {
                transform: translate(-40%, -60%);
                widows: 100%;
            }
            &-title {
                font-size: 2.5rem;
                padding-top: unset;
            }
            &-text {
                font-size: 1.2rem;
            }
            &-border-back {
                height: 45%;
            }
        }
    }
}
</style>