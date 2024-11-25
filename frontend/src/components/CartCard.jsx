import { Component } from "react";

export default class CartCard extends Component {

  render() {
    const { product } = this.props;
    return (
      <div className="flex items-center text-sm">
        <div className="w-2/3 flex">
          <div className="space-y-4 w-[88%] flex flex-col justify-center items-start">
            <div>
              <p className="font-semibold">{product.name}</p>
              <p>{product.price.currencySymbol}{product.price.amount}</p>
            </div>
            <div>
              {product.attributes?.map((attribute) => (
                <div className="mb-4" key={attribute.id}  
                data-testid={`cart-item-attribute-${attribute.id.replace(/([a-z])([A-Z])/g, '$1-$2').replace(/([0-9])([a-zA-Z])/g, '$1-$2').toLowerCase()}`}>
                  <p className="mb-2 font-semibold">{attribute.id[0].toUpperCase()}{attribute.id.slice(1)}:</p>
                  <div className="flex">
                    {attribute.items.map((item) => (
                      <div
                      data-testid={product.selectedAttributes[attribute.id].value === item.value ? `cart-item-attribute-${attribute.id.replace(/([a-z])([A-Z])/g, '$1-$2').replace(/([0-9])([a-zA-Z])/g, '$1-$2').toLowerCase()}-${item.value}-selected` 
                    : `cart-item-attribute-${attribute.id.replace(/([a-z])([A-Z])/g, '$1-$2').replace(/([0-9])([a-zA-Z])/g, '$1-$2').toLowerCase()}-${item.value}`}
                        key={item.value}
                        className={`text-sm  ${attribute.id.toLowerCase() === "color"
                            ? `w-8 h-8 border-2 mx-1  ${product.selectedAttributes[attribute.id].value === item.value
                              ? "border-green-500"
                              : "border-gray-300"
                            }`
                            : `px-2 py-1 border mx-1 ${product.selectedAttributes[attribute.id].value === item.value
                              ? "bg-black text-white"
                              : "bg-gray-200" 
                            }`
                          }`}
                        style={
                          attribute.id.toLowerCase() === "color"
                            ? { backgroundColor: item.value }
                            : {}
                        }
                      >
                        {attribute.id.toLowerCase() !== "color" && item.value}
                      </div>
                    ))}
                  </div>
                </div>
              ))}
            </div>
          </div>
          <div className="flex flex-col gap-6 justify-center items-center">
            <button data-testid='cart-item-amount-increase'
            className="border border-black w-6 h-6 flex items-center justify-center cursor-pointer hover:bg-black/70 hover:text-white transition"
            onClick={()=>{
              let products = [...this.props.products]
              products[this.props.indexOfProduct] = {
                ...products[this.props.indexOfProduct],
                quantity: products[this.props.indexOfProduct].quantity + 1
              }
              sessionStorage.setItem('productsInCart', JSON.stringify(products))
              this.props.productInCartsHendler()
            }}
            >+</button>
            <p>{product.quantity}</p>
            <button data-testid='cart-item-amount-decrease' 
            className="border border-black w-6 h-6 flex items-center justify-center cursor-pointer hover:bg-black/70 hover:text-white transition"
            onClick={()=>{
              let products = [...this.props.products]
              if( products[this.props.indexOfProduct].quantity <=1){
                products.splice(this.props.indexOfProduct,1)
              }else{
              products[this.props.indexOfProduct] = {
                ...products[this.props.indexOfProduct],
                quantity: products[this.props.indexOfProduct].quantity - 1
              }}
              sessionStorage.setItem('productsInCart', JSON.stringify(products))
              this.props.productInCartsHendler()
            }}
            >-</button>
          </div>
        </div>
        <div className="w-1/3 p-2">
              <img src={product.gallery[0]} />
        </div>
      </div>
    )
  }
}
