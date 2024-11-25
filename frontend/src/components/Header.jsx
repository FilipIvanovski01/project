import React, { Component } from "react";
import cart from "../img/cart.svg";
import logo from "../img/logo.svg";

export default class Header extends Component {
    
    render() {
       let pathName = window.location.pathname === "/" ? "all" :  window.location.pathname.split("/")[1]
        return (
            <>
                <div className="flex justify-between items-center px-20" id="header">
                    <div className="w-1/3 flex gap-8 justify-start">
                        {this.props.categories && this.props.categories.map((category, index) => (
                            <a
                                href={`/${category.toLowerCase()}`}
                                data-testid={pathName === category.toLowerCase() ? "active-category-link" : "category-link"}
                                className={
                                    pathName === category.toLowerCase()
                                        ? "text-[#5ECE7B] border-b-2 border-[#5ECE7B] pb-4 px-4 cursor-pointer"
                                        : "pb-4 px-4 cursor-pointer"
                                }
                                onClick={(e) => {
                                    e.preventDefault()
                                    this.props.changeUrl(`/${category.toLowerCase()}`)
                                    this.props.selectedCategoryHendler(category) }}
                                id={category}
                                key={index}
                            >
                                {category.toUpperCase()}
                            </a>
                        ))}
                    </div>
                    <div className="w-1/3 flex justify-center py-6">
                        <button><a href='/'><img src={logo} alt="Logo" /></a></button>
                    </div>
                    <div className="w-1/3 flex justify-end py-6">
                        <button className="relative" data-testid="cart-btn" onClick={()=> this.props.toggleCartVisibility()}>
                            {this.props.numberOfItemsInCart() > 0 &&
                             <div data-testid='cart-total' className="w-6 h-6 bg-black rounded-full absolute right-[-16px] top-[-2px] text-white"
                             >{this.props.numberOfItemsInCart()}</div>}
                            <img src={cart} alt="Cart" />
                        </button>
                    </div>
                </div>
            </>
        );
    }
}


