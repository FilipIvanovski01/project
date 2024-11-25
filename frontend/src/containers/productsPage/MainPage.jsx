import React, { Component } from "react";
import Card from "../../components/Card";

export default class MainPage extends Component {
 

  filteredProducts = (selectedCategory) => {
    if (selectedCategory.toLowerCase() === "all") {
      return this.props.products;
    }
    return this.props.products.filter((product) =>
        product.category.toLowerCase() === selectedCategory.toLowerCase()
    );
  };

  render() {
    const { products, selectedCategory} = this.props;

    return (
      <div className="px-20 py-12">
        <p className="text-3xl mb-6">
          {selectedCategory.charAt(0).toUpperCase() +
            selectedCategory.slice(1).toLowerCase()}
        </p>
        <div className="flex flex-wrap gap-24">
          {products && products.length > 0 ? (
            this.filteredProducts(selectedCategory).map((product, index) => (
              <Card
                key={index}
                product={product}
                productsInCart={this.props.productsInCart}
                changeUrl={this.props.changeUrl}
                productInCartsHendler={this.props.productInCartsHendler}
              />
              
            ))
          ) : (
            <p>No products available.</p>
          )}
          <div className="w-1/4 mx-auto"></div>
          <div className="w-1/4 mx-auto"></div>
        </div>
      </div>
    );
  }
}
