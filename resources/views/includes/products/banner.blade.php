<div class="banner start">
    <div class="banner__text">Все для здоровья кошек и собак в одном месте</div>
    <div class="banner__image"><img src="/images/dog.png"></div>
</div>
<style>
    .banner {
        width: 100%;
        /*height: 290px;*/
        max-width: 1200px;
        margin: 30px 0px 30px 0px;
        background: linear-gradient(42deg, #ff00cc 0%, #3300ff 100%);
        border-radius: 15px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        transition: 1.0s;
        transform: scale(1.0);
        z-index: 0;
    }

    .banner.start {
        transition: 0.0s;
        transform: scale(0.0);
    }    

    .banner__text {
        display: flex;
        font-family: "Arial", Arial, sans-serif;
        color: #FFF;
        width: 100%;
        max-width: 665px;
        margin: 20px 0px 20px 0px;
        line-height: 0.95;
        font-weight: 700;
        padding: 0px 40px 0px 57px;
        align-items: center;
        text-align: start;
    }

    @media (min-width: 0px) and (max-width: 1199px) {
        .banner__text {
            font-size: calc( (100vw - 320px)/(1200 - 320) * (65 - 16) + 16px);
        }

        .banner__image img {
            width: calc( (100vw - 320px)/(1200 - 320) * (276 - 100) + 100px);
            height: calc( (100vw - 320px)/(1200 - 320) * (320 - 120) + 120px);
        }

        .banner {
            height: calc( (100vw - 320px)/(1200 - 320) * (290 - 100) + 100px);
        }
    }

    @media (min-width: 1200px) {
        .banner__text {
            font-size: 65px;
        }

        .banner__image img {
            width: 276px;
            height: 320px;
        }

        .banner {
            height: 290px;
        }
    }

    .banner__image {
        margin-top: -30px;
        display: flex;
    }

</style>