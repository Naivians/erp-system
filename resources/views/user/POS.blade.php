<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Point of Sale</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            position: relative;
        }

        #itemsContainer {
            flex-grow: 1;
            max-height: 80vh;
            overflow-y: overlay;
        }

        .order-item {
            margin-bottom: 10px;
            border: none;
        }

        .card-body {
            padding: 5px;
        }

        .quantity-container {
            display: flex;
            align-items: center;
        }

        .quantity-input {
            width: 60px;
            margin: 0 5px;
        }

        .delete-btn {
            margin-left: 10px;
        }

        .header {
            background-color: #f1f1f1;
            text-align: start;
            padding: 5px;
        }

        .header a {
            margin: 0 15px;
            text-decoration: none;
            color: gray;
        }

        .header a:hover {
            color: black;
        }

        #itemsCard {
            width: 12rem;
            height: 7rem;
            padding: 10px;
            margin: 1rem;
            margin-right: 10px;
            text-align: center;
            border-radius: 3px;
            border: none;
            border-color: white;
            transition: transform 0.2s ease-in-out;
            box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
        }

        #itemsCard:active {
            transform: scale(0.95);
        }


        #itemsProductName {
            font-weight: bold;
        }

        .logoutBtn {
            --black: #000000;
            --ch-black: #141414;
            --eer-black: #1b1b1b;
            --night-rider: #2e2e2e;
            --white: #ffffff;
            --af-white: #f3f3f3;
            --ch-white: #e1e1e1;
            --gray: #808080;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 35px;
            height: 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: var(--gray);
            margin-left: 20px;
            margin-right: 10px;
        }

        /* plus sign */
        .logoutSign {
            width: 100%;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logoutSign svg {
            width: 17px;
        }

        .logoutSign svg path {
            fill: var(--af-white);
        }

        /* text */
        .logoutText {
            position: absolute;
            right: 0%;
            width: 0%;
            opacity: 0;
            color: var(--af-white);
            font-size: 1.0em;
            font-weight: 600;
            transition-duration: .3s;
        }

        /* hover effect on button width */
        .logoutBtn:hover {
            width: 100px;
            border-radius: 5px;
            transition-duration: .3s;
        }

        .logoutBtn:hover .logoutSign {
            width: 30%;
            transition-duration: .3s;
        }

        /* hover effect button's text */
        .logoutBtn:hover .logoutText {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 10px;
        }

        /* button click effect*/
        .logoutBtn:active {
            transform: translate(2px, 2px);
        }

        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        /* Order Card */

        .left-content {
            flex-grow: 1;
            text-align: left;
        }

        .right-content {
            display: flex;
            align-items: center;
        }

        .quantity-container {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        div::-webkit-scrollbar {
            display: none;
            /* Hide scroll bar in Chrome, Safari, and Opera */
        }

        .row {
            /* ... */
            max-height: 100vh;
            overflow-y: scroll;
            -ms-overflow-style: none;
            /* Hide scroll bar in IE and Edge */
            scrollbar-width: none;
            /* Hide scroll bar in Firefox */
        }

        .categoryButton {
            background: rgb(255, 255, 255);
            border: solid rgb(255, 255, 255);
            color: rgb(0, 0, 0);
            border-radius: 4px;
            font-weight: bold;
        }

        .subtotal-line {
            border: none;
            border-top: 3px solid #000000;
            margin: 0;
        }

        @media (max-width: 1400px) {

            /* Large desktop styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 12rem !important;
                height: 8rem;
                font-size: 16px;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.5em;
            }

            .product-name,
            .price {
                font-size: 0.8em;
            }

            .quantity-container .btn {
                font-size: 0.8em;
            }

            .delete-btn {
                font-size: 0.8em;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 1.0em;
            }

            #submitOrder {
                font-size: 0.9em;
            }
        }

        @media (max-width: 1350px) {

            /* Large desktop styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 11.5rem !important;
                height: 8rem;
                font-size: 16px;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.5em;
            }

            .product-name,
            .price {
                font-size: 0.8em;
            }

            .quantity-container .btn {
                font-size: 0.8em;
            }

            .delete-btn {
                font-size: 0.8em;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 1.0em;
            }

            #submitOrder {
                font-size: 0.9em;
            }
        }

        @media (max-width: 1300px) {

            /* Large desktop styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 11rem !important;
                height: 8rem;
                font-size: 16px;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.5em;
            }

            .product-name,
            .price {
                font-size: 0.8em;
            }

            .quantity-container .btn {
                font-size: 0.8em;
            }

            .delete-btn {
                font-size: 0.8em;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 1.0em;
            }

            #submitOrder {
                font-size: 0.9em;
            }
        }

        @media (max-width: 1250px) {

            /* Large desktop styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 10.6rem !important;
                height: 8rem;
                font-size: 16px;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.5em;
            }

            .product-name,
            .price {
                font-size: 0.8em;
            }

            .quantity-container .btn {
                font-size: 0.8em;
            }

            .delete-btn {
                font-size: 0.8em;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 1.0em;
            }

            #submitOrder {
                font-size: 0.9em;
            }
        }

        @media (max-width: 1225px) {

            /* Large desktop styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 10.4rem !important;
                height: 8rem;
                font-size: 16px;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.5em;
            }

            .product-name,
            .price {
                font-size: 0.8em;
            }

            .quantity-container .btn {
                font-size: 0.8em;
            }

            .quantity-input {
                font-size: 12px !important;
                padding: 7px;
                width: 50px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 0.8em;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 1.0em;
            }

            #submitOrder {
                font-size: 0.9em;
            }
        }

        /* Styles for large desktops */
        @media (max-width: 1200px) {

            /* Large desktop styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 10rem !important;
                height: 8rem;
                font-size: 16px;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.5em;
            }

            .product-name,
            .price {
                font-size: 0.8em;
            }

            .quantity-container .btn {
                font-size: 0.8em;
            }

            .quantity-input {
                font-size: 12px !important;
                padding: 7px;
                width: 50px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 0.8em;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 1.0em;
            }

            #submitOrder {
                font-size: 0.9em;
            }
        }

        @media (max-width: 1150px) {

            /* Large desktop styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 9.5rem !important;
                height: 7.5rem;
                font-size: 16px;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                font-size: 13px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.3em;
            }

            .product-name,
            .price {
                font-size: 12px !important;
            }

            .quantity-container .btn {
                font-size: 12px !important;
                padding: 10px;
                border-radius: 3px;
            }

            .quantity-input {
                font-size: 12px !important;
                padding: 7px;
                width: 40px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 12px;
                padding: 10px;
                border-radius: 3px;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 17px;
            }

            #submitOrder {
                font-size: 14px;
            }
        }

        @media (max-width: 1100px) {

            /* Smaller desktop and laptop styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 9rem !important;
                height: 6rem;
                font-size: 13px;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.3em;
            }

            .product-name,
            .price {
                font-size: 12px !important;
            }

            .quantity-container .btn {
                font-size: 12px !important;
                padding: 8px;
                border-radius: 3px;
            }

            .quantity-input {
                font-size: 12px !important;
                padding: 5px;
                width: 40px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 12px;
                padding: 8px;
                border-radius: 3px;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 17px;
            }

            #submitOrder {
                font-size: 14px;
            }
        }

        @media (max-width: 1050px) {

            /* Smaller desktop and laptop styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 8.5rem !important;
                height: 6rem;
                font-size: 11px;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.3em;
            }

            .product-name,
            .price {
                font-size: 12px !important;
            }

            .quantity-container .btn {
                font-size: 10px !important;
                padding: 8px;
                border-radius: 3px;
            }

            .quantity-input {
                font-size: 12px !important;
                padding: 4px;
                width: 40px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 10px;
                padding: 8px;
                border-radius: 3px;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 15px;
            }

            #submitOrder {
                font-size: 13px;
            }
        }

        @media (max-width: 1000px) {

            /* Smaller desktop and laptop styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 8rem !important;
                height: 6rem;
                font-size: 13px;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                font-size: 11px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.3em;
            }

            .product-name,
            .price {
                font-size: 11px !important;
            }

            .quantity-container .btn {
                font-size: 9px !important;
                padding: 8px;
                border-radius: 3px;
            }

            .quantity-input {
                font-size: 12px !important;
                padding: 4px;
                width: 40px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 9px;
                padding: 8px;
                border-radius: 3px;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 14px;
            }

            #submitOrder {
                font-size: 12px;
            }

            .categoryButton {
                font-size: 15px;
            }
        }

        /* Styles for landscape tablets */
        @media (max-width: 950px) {

            /* Landscape tablet styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 7.5rem !important;
                height: 6rem;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                font-size: 11px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.3em;
            }

            .product-name,
            .price {
                font-size: 10px !important;
            }

            .quantity-container .btn {
                font-size: 9px !important;
                padding: 8px;
                border-radius: 3px;
            }

            .quantity-input {
                font-size: 12px !important;
                padding: 4px;
                width: 40px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 9px;
                padding: 8px;
                border-radius: 3px;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 14px;
            }

            #submitOrder {
                font-size: 12px;
            }

            .categoryButton {
                font-size: 14px;
            }
        }

        @media (max-width: 900px) {

            /* Landscape tablet styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 7rem !important;
                height: 6rem;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                font-size: 11px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.3em;
            }

            .product-name,
            .price {
                font-size: 9px !important;
            }

            .quantity-container .btn {
                font-size: 8px !important;
                padding: 8px;
                border-radius: 3px;
            }

            .quantity-input {
                font-size: 12px !important;
                padding: 4px;
                width: 40px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 8px;
                padding: 8px;
                border-radius: 3px;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 12px;
            }

            #submitOrder {
                font-size: 10px;
            }

            .categoryButton {
                font-size: 12px;
            }
        }

        @media (max-width: 850px) {

            /* Landscape tablet styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 9rem !important;
                height: 6rem;
                padding: 10px;
                margin: 1rem;
                font-size: 10px;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.3em;
            }

            .product-name,
            .price {
                font-size: 9px !important;
            }

            .quantity-container .btn {
                font-size: 7px !important;
                padding: 5px;
                border-radius: 3px;
            }

            .quantity-input {
                font-size: 10px !important;
                padding: 2px;
                width: 30px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 7px;
                padding: 5px;
                border-radius: 3px;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 12px;
            }

            #submitOrder {
                font-size: 10px;
            }

            .categoryButton {
                font-size: 12px;
                margin-left: 30px !important;
            }
        }

        @media (max-width: 800px) {

            /* Landscape tablet styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 8.5rem !important;
                height: 6rem;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1.3em;
            }

            .product-name,
            .price {
                font-size: 8px !important;
            }

            .quantity-container .btn {
                font-size: 8px !important;
                padding: 6px;
                border-radius: 3px;
            }

            .quantity-input {
                font-size: 10px !important;
                padding: 5px;
                width: 40px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 8px;
                padding: 6px;
                border-radius: 3px;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 12px;
            }

            #submitOrder {
                font-size: 12px;
            }

            .categoryButton {
                font-size: 12px;
                margin-left: 20px !important;
            }
        }

        @media (max-width: 750px) {

            /* Landscape tablet styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 70vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 11rem !important;
                height: 6rem;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1em;
            }

            .product-name,
            .price {
                font-size: 8px !important;
            }

            .quantity-container .btn {
                font-size: 7px !important;
                padding: 6px;
                border-radius: 2px;
            }

            .quantity-input {
                font-size: 10px !important;
                padding: 5px;
                width: 40px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 7px;
                padding: 6px;
                border-radius: 2px;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 10px;
            }

            #submitOrder {
                font-size: 10px;
            }

            .categoryButton {
                font-size: 10px;
                margin-left: 18px !important;
            }
        }

        @media (max-width: 700px) {

            /* Landscape tablet styles */
            #itemsContainer {
                flex-grow: 1;
                max-height: 80vh;
                overflow-y: overlay;
            }

            #itemsCard {
                width: 11rem !important;
                height: 6rem;
                padding: 10px;
                margin: 1rem;
                margin-right: 10px;
                text-align: center;
                border-radius: 3px;
                border: none;
                border-color: white;
                transition: transform 0.2s ease-in-out;
                box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -webkit-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
                -moz-box-shadow: 0px 1px 10px 6px rgba(0, 0, 0, 0.06);
            }

            #itemsCard:active {
                transform: scale(0.95);
            }

            .currentorderText {
                font-size: 1em;
            }

            .product-name,
            .price {
                font-size: 8px !important;
            }

            .quantity-container .btn {
                font-size: 7px !important;
                padding-top: 5px;
                padding-bottom: 5px;
                border-radius: 2px;
            }

            .quantity-input {
                font-size: 10px !important;
                padding: 4px;
                width: 40px;
                /* Adjust the width as needed */
            }

            .delete-btn {
                font-size: 7px;
                padding: 5px;
                border-radius: 2px;
                margin-left: 0;
            }

            #discount,
            #subtotal,
            #discountText,
            #subtotalText,
            #total,
            #totalText {
                font-size: 10px;
            }

            #submitOrder {
                font-size: 10px;
            }

            .categoryButton {
                font-size: 10px;
                margin-left: 20px !important;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header d-flex justify-content-between align-items-center">
            <div>
                <a class="ms-5" href="{{ route('Users.orders') }}">Transaction History</a>
                <a href="{{ route('Users.POS') }}">Point of Sale</a>
            </div>
            <form action="{{ route('Logins.logout') }}" method="get">
                @csrf
                @method('get')
                <button type="submit" class="logoutBtn me-5">
                    <div class="logoutSign">
                        <svg viewBox="0 0 512 512">
                            <path
                                d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                            </path>
                        </svg>
                    </div>
                    <div class="logoutText">Logout</div>
                </button>
            </form>
        </div>
    </div>

    <div class="container-fluid" style="height:90vh;">
        <div class="row">
            <div class="col-8 col-md-8" style="background-color: #d1d1d1;flex-grow: 1;height:100vh;">
                <div class="row">
                    <div class="col-12 col-md-12 mt-4">
                        @foreach ($categories as $category)
                            <button class="ms-5 categoryButton" data-category="{{ $category->category }}">
                                <i class="fa-solid fa-bowl-food"></i>
                                <!-- Replace 'icon-name' with the name of the icon you want to use -->
                                {{ $category->category }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 mt-3" id="itemsContainer">
                        <!-- Products will be dynamically added here -->
                    </div>
                </div>
            </div>
            <div class="col-4 col-md-4 d-flex flex-column position-relative"
                style="max-height:100vh;background-color:rgb(255, 255, 255);overflow-y:overlay;">
                <h3 class="mt-4 currentorderText" style="font-weight:bold;">Current Order</h3>
                <div id="currentOrder" style="flex-grow: 1; overflow-y: auto; max-height: calc(100vh - 280px);">
                    <!-- Order cards will be added here -->
                </div>
                <div class="position-absolute bottom-0 w-100 pe-3" style="height: 180px;">
                    <div class="d-flex justify-content-between mb-2">
                        <div id="subtotalText">Subtotal:</div>
                        <div class="text-nowrap">
                            <span id="subtotal" class="text-end">₱ 0.00</span>
                        </div>
                    </div>
                    <div class="w-100 mb-2">
                        <hr class="subtotal-line">
                    </div>
                    <div class="d-flex justify-content-between">
                        <h4 id="totalText">Total:</h4>
                        <div class="text-nowrap mb-2">
                            <h4 id="total" class="text-end">₱ 0.00</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <div class="text-nowrap m-auto">
                            <button class="btn btn-success btn-sm mb-5" id="submitOrder"><i
                                    class="fa-solid fa-cart-shopping"></i> SUBMIT ORDER</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load session data when the page loads
            $.get('/session-data', function(data) {
                for (var i = 0; i < data.length; i++) {
                    var item = data[i];
                    addToOrder(item);
                }

                $('.quantity-input').on('input', function() {
                    updateSessionData();
                });
            });

            // Will handle adding the items to the current order.
            function addToOrder(product) {
                // Check if the item already exists in the current order
                var existingOrderItem = $('.order-item').filter(function() {
                    return $(this).find('.product-name').text() === product
                        .product_name;
                });

                if (existingOrderItem.length > 0) {
                    // Item already exists, do nothing
                    return;
                } else {
                    // Item doesn't exist, add it to the current order
                    var orderCard = $('<div class="card order-item"></div>');
                    var cardBody = $(
                        '<div class="card-body d-flex justify-content-between align-items-center"></div>'
                    );
                    var leftContent = $('<div class="left-content"></div>');
                    var productName = $('<p class="product-name mb-0">' + product
                        .product_name + '</p>');
                    var price = $('<p class="price mb-0">Price: ₱ ' + product
                        .price + '</p>');
                    var rightContent = $('<div class="right-content"></div>');
                    var quantityContainer = $('<div class="quantity-container"></div>');
                    var minusButton = $(
                        '<button class="btn btn-danger minus-btn"><i class="fa-solid fa-minus"></i></button>');
                    var quantity = product.quantity ? product.quantity : 1;
                    var quantityInput = $('<input type="number" class="form-control quantity-input" value="' +
                        quantity + '" min="1">');
                    var plusButton = $(
                        '<button class="btn btn-success plus-btn"><i class="fa-solid fa-plus"></i></button>');
                    var deleteButton = $(
                        '<button class="btn btn-danger delete-btn"><i class="fa-solid fa-trash"></i></button>');

                    leftContent.append(productName, price);
                    quantityContainer.append(minusButton, quantityInput,
                        plusButton);
                    cardBody.append(leftContent, quantityContainer, deleteButton);
                    orderCard.append(cardBody);

                    $('#currentOrder').append(orderCard);
                    updateSessionData();

                    // Add event listeners for the minus, plus, and delete buttons
                    minusButton.click(function() {
                        var quantityInput = $(this).siblings('.quantity-input');
                        var currentQuantity = parseInt(quantityInput.val());
                        if (currentQuantity > 1) {
                            quantityInput.val(currentQuantity - 1);
                            calculateTotals();
                            updateSessionData();
                        }
                    });

                    plusButton.click(function() {
                        var quantityInput = $(this).siblings('.quantity-input');
                        var currentQuantity = parseInt(quantityInput.val());
                        quantityInput.val(currentQuantity + 1);
                        calculateTotals();
                        updateSessionData();
                    });

                    deleteButton.click(function() {
                        orderCard.remove();
                        calculateTotals();
                        updateSessionData();
                    });

                    // Add event listener for quantity input field
                    quantityInput.on('input', function() {
                        var currentQuantity = parseInt($(this).val());
                        if (currentQuantity < 1 || $(this).val() === '') {
                            $(this).val(1); // Reset the value to 1 if it's less than 1
                        }
                        calculateTotals();
                        updateSessionData();
                    });

                    // Call calculateTotals after adding the order item
                    calculateTotals();
                }
            }

            var subtotal = 0;
            var total = 0;

            function calculateTotals() {
                subtotal = 0;
                total = 0;

                $('.order-item').each(function() {
                    var quantity = parseInt($(this).find('.quantity-input')
                        .val());
                    var price = parseFloat($(this).find('.price').text()
                        .replace('Price: ₱ ', ''));
                    var itemTotal = quantity * price;

                    subtotal += itemTotal;
                });

                total =
                    subtotal; // For now, we'll assume no additional charges or deductions

                $('#subtotal').text(' ₱ ' + subtotal.toFixed(2));
                $('#total').text(' ₱ ' + total.toFixed(2));
            }

            $('.categoryButton').click(function() {
                var category = $(this).data('category');

                $.ajax({
                    url: '/pos/' + category,
                    type: 'GET',
                    success: function(data) {
                        // Clear the current items
                        $('.itemsCard').remove();

                        // Append the new items based on the selected category
                        // Click event listener to itemsCard.
                        var cardsContainer = $(
                            '<div class="cards-container d-flex flex-wrap"></div>');
                        $.each(data, function(index, product) {
                            var itemCard = $(
                                '<div class="card itemsCard" id="itemsCard"></div>');
                            var itemContent = $('<div class="card-body"></div>');
                            itemContent.append(
                                '<p class="card-title" id="itemsProductName">' +
                                product
                                .product_name + '</p>');
                            itemContent.append('<p class="card-text">Price: ₱ ' +
                                product.price + '</p>');
                            itemCard.append(itemContent);
                            cardsContainer.append(itemCard);
                            itemCard.click(function() {
                                addToOrder(product);
                            });
                            cardsContainer.append(itemCard);
                        });
                        $('#itemsContainer').append(cardsContainer);


                    },
                    error: function() {
                        alert('Error fetching products.');
                    }
                });
            });

            // function for session
            function updateSessionData() {
                var orderData = [];
                $('.order-item').each(function() {
                    var productName = $(this).find('.product-name').text();
                    var price = parseFloat($(this).find('.price').text().replace(
                        'Price: ₱ ', ''));
                    var quantity = parseInt($(this).find('.quantity-input').val());

                    orderData.push({
                        product_name: productName,
                        price: price,
                        quantity: quantity
                    });

                    console.log(orderData);
                });

                $.ajax({
                    url: '/update-session',
                    type: 'POST',
                    data: {
                        order: orderData,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Session data updated successfully.');
                    },
                    error: function() {
                        console.log('Error updating session data.');
                    }
                });
            }

            $('#submitOrder').click(function() {
                var orderData = [];
                $('.order-item').each(function() {
                    var productName = $(this).find('.product-name').text();
                    var price = parseFloat($(this).find('.price').text().replace('Price: ₱ ', ''));
                    var quantity = parseInt($(this).find('.quantity-input').val());

                    orderData.push({
                        product_name: productName,
                        price: price * quantity,
                        quantity: quantity
                    });
                });

                $.ajax({
                    url: '/place-order',
                    type: 'POST',
                    data: {
                        order: orderData,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Clear the current order section
                            $('#currentOrder').empty();
                            // Reset the subtotal and total variables
                            subtotal = 0;
                            total = 0;
                            // Update the subtotal and total elements
                            $('#subtotal').text('Subtotal: ₱ ' + subtotal.toFixed(2));
                            $('#total').text('Total: ₱ ' + total.toFixed(2));

                            // Show success alert
                            Swal.fire(
                                'Success!',
                                'Order placed successfully!',
                                'success'
                            );

                            // Open the receipt in a new window and print it
                            var receiptWindow = window.open('');
                            receiptWindow.document.write(response.receipt);
                            receiptWindow.print();
                            var printIframe = document.createElement('iframe');
                            printIframe.style.display = 'none';
                            document.body.appendChild(printIframe);
                            printIframe.contentDocument.write(response.receipt);
                            printIframe.contentDocument.close();
                            printIframe.contentWindow.print();
                        }
                    },
                    error: function() {
                        // Show error alert
                        Swal.fire(
                            'Error!',
                            'Error placing order. Please try again.',
                            'error'
                        );
                    }
                });
            });

        });
    </script>

</body>

</html>
