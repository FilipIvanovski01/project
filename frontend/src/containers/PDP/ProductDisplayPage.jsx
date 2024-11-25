import React, { Component } from "react";
import { FetchProduct } from "../../components/functions/fetch";
import PdpGallery from "../../components/PdpGallery";
import Description from "../../components/Description";

export default class ProductDisplayPage extends Component {
  constructor(props) {
    super(props);
    this.state = {
      product: null,
      error: null,
      loading: true,
    };
  }

  componentDidMount() {
    const productId = window.location.pathname.split("/")[2]
    FetchProduct(import.meta.env.VITE_API_URL, productId)
      .then((data) => {
        this.setState({
          product: data?.data?.products[0],
          loading: false,
        });
      })
      .catch((error) => {
        this.setState({ error, loading: false });
        console.error("Error fetching product:", error);
      });
  }

  render() {
    const { product, error, loading } = this.state;

    if (loading) {
      return <div className="flex items-center justify-center h-screen">Loading...</div>;
    }

    if (error) {
      return (
        <div className="flex items-center justify-center h-screen text-red-500">
          Something went wrong. Try again.
        </div>
      );
    }

    return (
      <div className="flex h-[80vh] items-center justify-center">
        <div className="w-1/2 items-center justify-center"><PdpGallery gallery={product?.gallery} /></div>
        <div className="w-1/2 items-center justify-center "><Description 
        toggleCartVisibility={this.props.toggleCartVisibility}
        product={product} 
        productInCartsHendler={this.props.productInCartsHendler} 
        productsInCart={this.props.productsInCart} /></div>
    </div>
    );
  }
}
