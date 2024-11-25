import React, { Component } from "react";
import parse from 'html-react-parser';
import DOMPurify from 'dompurify';

export default class Description extends Component {
  constructor(props) {
    super(props);
    this.state = {
      selectedAttributes: {},
    };
  }

  handleAttributeSelection = (attributeType, value, displayValue) => {
    this.setState((prevState) => ({
      selectedAttributes: {
        ...prevState.selectedAttributes,
        [attributeType]: {
          id: attributeType,
          value: value,
          displayValue: displayValue
        }
      }
    }));
  };

  allSelectedAttributes = (product) => {
    let allAttributesSelected = true;
    product.attributes.forEach((attribute) => {
      if (!this.state.selectedAttributes[attribute.id]) {
        allAttributesSelected = false;
      }
    })
    return allAttributesSelected
  }

  addProductInCart(product) {
    
    let productsInCart =JSON.parse(sessionStorage.getItem("productsInCart")) ? JSON.parse(sessionStorage.getItem("productsInCart")) : [] 

    if (this.allSelectedAttributes(product)) {
      let sameProductInCart = false
      productsInCart.forEach((prod, index) => {
        if (prod.id === product.id) {
          let sameAttributes = true
          for (let attribute in prod.selectedAttributes) {
            if (this.state.selectedAttributes[attribute].value !== prod.selectedAttributes[attribute].value) {
              sameAttributes = false
              continue
            }
          }
          if (sameAttributes) {
            sameProductInCart = true;
            productsInCart[index] = { ...productsInCart[index], quantity: productsInCart[index].quantity + 1 }
            sessionStorage.setItem("productsInCart", JSON.stringify(productsInCart))
            return
          }
        }
      })
      if (!sameProductInCart) {
        const newProduct = {
          ...product,
          quantity: 1,
          selectedAttributes: this.state.selectedAttributes,
        };
        productsInCart.push(newProduct);
        sessionStorage.setItem("productsInCart", JSON.stringify(productsInCart))
      }
    } 
    this.props.productInCartsHendler()
    this.props.toggleCartVisibility()

  }

  parsedDescription = () => {
      const sanitizedDescription = DOMPurify.sanitize(this.props.product.description);
      return parse(sanitizedDescription)
    }
  

  render() {
    const { product } = this.props;
    const { selectedAttributes } = this.state;

    return (

      <div className="w-3/6 h-[50vh] space-y-6 pl-32">
        <p className="text-2xl font-bold">{product.name}</p>
        {product.attributes?.map((attribute) => (
          <div key={attribute.id}>
            <p className="font-semibold">{attribute.id.toUpperCase()}:</p>
            <div className="flex gap-x-4"
              data-testid={`product-attribute-${attribute.id.replace(/([a-z])([A-Z])/g, '$1-$2').replace(/([0-9])([a-zA-Z])/g, '$1-$2').toLowerCase()}`}>
              {attribute.items.map((item) => {
                const isSelected = selectedAttributes[attribute.id]
                  ? selectedAttributes[attribute.id].value === item.value
                  : false;
                return (
                  <div
                    data-testid={`product-attribute-${attribute.id.replace(/([a-z])([A-Z])/g, '$1-$2').replace(/([0-9])([a-zA-Z])/g, '$1-$2').toLowerCase()}-${item.value}`}
                    key={item.value}
                    onClick={() => this.handleAttributeSelection(attribute.id, item.value, item.displayValue)}
                    className={`cursor-pointer ${attribute.id.toLowerCase() === "color"
                      ? `w-12 h-12 border-2 ${isSelected ? "border-green-500" : "border-gray-300"}`
                      : `px-4 py-2 border ${isSelected ? "bg-black text-white" : "hover:bg-gray-200"}`
                      }`}
                    style={
                      attribute.id.toLowerCase() === "color"
                        ? { backgroundColor: item.value }
                        : {}
                    }
                  >
                    {attribute.id.toLowerCase() !== "color" && item.value}
                  </div>
                );
              })}
            </div>
          </div>
        ))}
          <div className="space-y-2 text-xl font-bold pt-6">
          <p>PRICE:</p>
          <p>
            {product.price?.currencySymbol}
            {product.price?.amount}
          </p>
        </div>
          <button 
            data-testid='add-to-cart' 
            onClick={() => {if(product.inStock && this.allSelectedAttributes(product)){this.addProductInCart(product)} }} 
            className={product.inStock & this.allSelectedAttributes(product) ? "w-full bg-green-400 h-12 text-white hover:bg-green-400/70" 
            : "w-full bg-gray-400 h-12 text-white" }
            disabled={!product.inStock || !this.allSelectedAttributes(product)}
            >ADD TO CART</button> 
          
        

        <div className="h-1/2 overflow-y-auto w-full" data-testid='product-description'>
          {product.description && (
            <div>{this.parsedDescription()}</div>
          )}
        </div>
      </div>
    );
  }
}
