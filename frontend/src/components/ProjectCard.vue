<template>
  <div class="cardflip mb-3">
    <b-card
      overlay 
      :img-src="imgSrc" 
      :img-alt="imgAlt" 
      :title="title"
      :date="date" 
      class="frontcard">
    </b-card>        
    <b-card class="backcard">
      <b-card-text>
        <p class="card-text-date">{{ formatDate }}</p>
        <p class="card-text-content">{{ content }}</p>
      </b-card-text>
      <b-link :href="url" class="btn">Vers le site</b-link>
    </b-card>
  </div>
</template>

<script>
export default {
  name: "Project",
  props: {
    title: String,
    content: String,
    color: String,
    url: String,
    imgSrc: String,
    imgAlt: String,
    date: String
  },
  computed: {
    formatDate () {
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      let formatDate = new Date(this.date).toLocaleDateString(undefined, options);
      return formatDate.charAt(0).toUpperCase() + formatDate.slice(1);
    }
  },
}
</script>

<style lang="scss">
.cardflip {
  font-family: 'Oswald', sans-serif;
  .card-title {
    color: $white;       
    text-transform: uppercase;
    @include special-text-shadow;
  }
  .frontcard,
  .backcard {
    transition-timing-function: cubic-bezier(.175, .885, .32, 1.275);
    transition-duration: 1s;
    transition-property: transform, opacity;
    color: white;
    padding: 0.5em;
    background: $white;
    border-radius: 10px;
    .card-title {
      font-size: 3rem;
    }
  }
  .frontcard {
    transform: rotateY(0deg);
    @include box_shadow(0px, 0px, 5px, $white);
    background: $white;
    .card-body {
      display: flex;
      flex-direction: column;
      justify-content: center
    }
  }
  .backcard {
    position: absolute;
    opacity: 0;
    top: 0px;
    left: 0px;
    width: inherit;
    height: 100%;
    transform: rotateY(-180deg);
    @include box_shadow(0px, 0px, 30px, $purple);
    @include box_shadow(0px, 0px, 1px, $purple);
    .card-text {
      padding: 0.5rem;
      font-size: 1.1rem;
      line-height: 2rem;
      color: $purple;
      border-radius: 10px;
    }
    .card-body {
      display: flex;
      flex-direction: column;
      .btn {
        color: $purple!important;
        background-color: transparent!important;
        border: 1px solid $purple!important;
        transform: translateZ(100px);
        &:hover {
          color: $white!important;
          background-color: $purple!important;
          @include box_shadow(0px, 0px, 10px, $purple); 
        }
      }
    }
  }
  &:hover {
    .frontcard {
      transform: rotateY(180deg);
    }
    .backcard {
      opacity: 1;
      transform: rotateY(0deg);
    }
  }
}

@media (min-width: 320px) {
  .cardflip {
    width: 100%;
    margin: 1rem;
    .frontcard {
      .card-title {
        font-size: 1.5rem;
      }
    }
    .backcard {
      .card-body {
        padding: unset;   
        justify-content: center;            
        .card-text {
          padding: unset;
          font-size: 0.6rem;
          line-height: unset;
          &-date {
            margin-bottom: 0.25rem;
          }
          &-content {
            margin-bottom: 0;
          }
        }
      }
    }
  }
}
@media (min-width: 576px) {
  .cardflip {
    .frontcard {
      .card-title {
        font-size: 2rem;
      }
    }
    .backcard {
      .card-body {
        padding: 1.25rem;                     
        .card-text {
          padding: 0.6rem;
          font-size: 1.2rem;
          line-height: 2rem;
          
        }
      }
    }
  }
}
@media (min-width: 768px) {
  .cardflip {
    width: 40rem;
    .frontcard {
      .card-title {
        font-size: 3rem;
      }
    }
    .backcard {
      .card-body {   
        justify-content: space-around;              
        .card-text {
          padding: 0.8rem;
          font-size: 1.4rem;
          line-height: 2.1rem;
          &-date {
            margin-bottom: 1.5rem;
          }
          &-content {
            margin: 0;
          }
        }
      }
    }
  }
}
</style>