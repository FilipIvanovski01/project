import React, { Component } from "react";
import { FetchData } from "./components/functions/fetch";
import { Categories } from "./components/functions/categoryType"
import MainPage from "./containers/productsPage/MainPage";
import ProductDisplayPage from "./containers/PDP/ProductDisplayPage";
import Header from "./components/Header";
import Cart from "./components/Cart";

export default class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
      products: null,
      categories: null,
      cartVisibility: false,
      selectedCategory: "ALL",
      productInCarts: [],
      loading: true,
      error: null,
      currentUrl: window.location.pathname
    };
  }

  componentDidMount() {
    FetchData(import.meta.env.VITE_API_URL)
      .then((data) => {
        this.setState({
          products: data.data.products,
          categories: Categories(data.data.products),
          loading: false,
        });
      })
      .catch((error) => {
        this.setState({ error, loading: false })
      });
    window.addEventListener("popstate", ()=>{this.setState({ currentUrl: window.location.pathname })})
    this.productInCartsHendler()
  }
  componentWillUnmount() {
      removeEventListener("popstate", ()=>{this.setState({ currentUrl: window.location.pathname })})
  }
  countItemsInCart = () => {
    let itemsInCart = 0
    this.state.productInCarts.forEach(item => {
        itemsInCart += item.quantity
    });
    return itemsInCart
  }
  productInCartsHendler = () => {
    if(sessionStorage.getItem("productsInCart")){
      this.setState({ productInCarts: JSON.parse(sessionStorage.getItem("productsInCart"))})
    }else{
      this.setState({productInCarts: []})
    }

  };

  selectedCategoryHendler = (category) => {
    this.setState({selectedCategory: category})
  }

  changeUrl = (url) => {
    window.history.pushState(null,"",url)
    this.setState({currentUrl: url})
  }

  toggleCartVisibility = () => {
    this.setState((prevState) => ({
      cartVisibility: !prevState.cartVisibility,
    }));
  };

  render() {
    const {
      products,
      categories,
      selectedCategory,
      cartVisibility,
      loading,
      error,
      currentUrl
    } = this.state;

    if (loading) {
      return <div className="flex items-center justify-center h-screen">Loading...</div>
    }

    if (error) {
      return (
        <div className="flex items-center justify-center h-screen text-red-500">
          Something went wrong. Try again.
        </div>
      );
    }
    let pathname = currentUrl === "/" ? "/all" : currentUrl;
    const parthArray = pathname.split("/")
    const isMainPage = parthArray[1] && this.state.categories.some(category => category.toLowerCase() === parthArray[1].toLowerCase());
    const isProductPage = parthArray[0] === "product" && parthArray.length > 1;
    console.log(pathname)
    return (
      <>  
        <Header
          categories={categories}
          selectedCategory={selectedCategory}
          selectedCategoryHendler={this.selectedCategoryHendler}
          toggleCartVisibility={this.toggleCartVisibility}
          numberOfItemsInCart={this.countItemsInCart}
          changeUrl={this.changeUrl}
          currentUrl={this.state.currentUrl}
        />
        
        {cartVisibility && <Cart toggleCartVisibility={this.toggleCartVisibility}
          productsInCart={this.state.productInCarts}
          productInCartsHendler={this.productInCartsHendler} />}
      {isMainPage && (
        <MainPage
        products={products}
        categories={categories}
        selectedCategory={selectedCategory}
        productsInCart={this.state.productInCarts}
        productInCartsHendler={this.productInCartsHendler}
        changeUrl={this.changeUrl}
      />)
      } 
      {isProductPage && (
        <ProductDisplayPage 
        productInCartsHendler={this.productInCartsHendler} 
        productsInCart={this.state.productInCarts} 
        toggleCartVisibility={this.toggleCartVisibility}
        />
      )}
        


      </>
    );
  }
}