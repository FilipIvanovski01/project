import { Component, ReactNode } from "react";
import CartCard from "./CartCard"

export default class Cart extends Component {

    turnoff = (e) => {
        if (e.target.id == "parent") {
            this.props.toggleCartVisibility()
        }
    };
    itemsInCart = () => {
        let index = 0
        this.props.productsInCart.forEach(product => {
            index += product.quantity
        });
        return index
    }
    cartTotal = () => {
        let total = 0
        this.props.productsInCart.forEach(product => {
            total += product.quantity * product.price.amount
        });
        return total.toFixed(2)
    }
    saveOrder = () => {
        let orders = this.props.productsInCart.map((product) => {
            return {
                "productId": product.id,
                "quantity": product.quantity,
                "choosenAttributes": Object.values(product.selectedAttributes)
            }
        })
           
        console.log(orders)
        fetch(import.meta.env.VITE_API_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                query: `
                    mutation SaveOrder($products: [ProductInput!]!) {
                        saveOrder(products: $products) {
                            items {
                                productId
                                quantity
                                choosenAttributes {
                                    id
                                    value
                                    displayValue
                                }
                            }
                        }
                    }
                `,
                variables: { products: orders }
            })
        })
            .then(response => response.text())  
            .then(result => {
                console.log(result)})
            .catch(error => {
                console.error("Error saving order:", error)
            });
        sessionStorage.setItem('productsInCart', JSON.stringify([]))
        this.props.productInCartsHendler()
    }

    render() {
        const productsInCart = this.props.productsInCart
        return (
            <>
                <div id="parent" onClick={this.turnoff} className="h-screen w-full absolute bg-[#39374838] z-50">
                    <div className=" bg-white w-1/4 max-h-[66%] min-h-[10%] justify-self-end mx-12 overflow-y-auto p-6 " data-testid="cart-overlay">
                        {productsInCart.length > 0 && <p className="mb-6"><span className="font-semibold">My Bag,</span> {this.itemsInCart()} items</p>}
                        {productsInCart.length > 0 && (
                            productsInCart.map((product, index) => (
                                <div key={index} className={`mb-4  ${index !== productsInCart.length - 1 ? 'border-b' : ''}`}>
                                    <CartCard indexOfProduct={index}
                                        product={product} products={productsInCart}
                                        productInCartsHendler={this.props.productInCartsHendler} />
                                </div>
                            ))
                        )}
                        <p data-testid='cart-item-amount' className="flex justify-between my-4"><span className="font-semibold">Total</span>${this.cartTotal()}</p>
                        <div className="text-center">
                            {productsInCart.length > 0 ?
                                (<button className=" text-white w-2/3 h-10 rounded-lg bg-[#5ECE7B] mx-auto hover:bg-[#5ECE7B]/70"
                                    onClick={() => { this.saveOrder() }}>PLACE ORDER</button>) :
                                (<button disabled className=" text-white w-2/3 h-10 rounded-lg bg-gray-300 mx-auto">PLACE ORDER</button>)}
                        </div>
                    </div>
                </div>
            </>
        )
    }
}