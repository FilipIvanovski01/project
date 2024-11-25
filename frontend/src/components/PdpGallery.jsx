import React, { Component } from "react";
import leftArrow from "../img/leftArrow.svg";
import rightArrow from "../img/rightArrow.svg";

export default class PdpGallery extends Component {
  constructor(props) {
    super(props);
    this.state = {
      photoIndex: 0,
    };
  }

  prevPhotoHandler = () => {
    this.setState((prevState, props) => {
      const galleryLength = props.gallery?.length || 0;
      const newIndex = prevState.photoIndex === 0 ? galleryLength - 1 : prevState.photoIndex - 1;
      return { photoIndex: newIndex };
    });
  };

  nextPhotoHandler = () => {
    this.setState((prevState, props) => {
      const galleryLength = props.gallery?.length || 0;
      const newIndex = prevState.photoIndex === galleryLength - 1 ? 0 : prevState.photoIndex + 1;
      return { photoIndex: newIndex };
    });
  };

  render() {
    const { gallery } = this.props;
    const { photoIndex } = this.state;


    return (
      <div className="flex" data-testid='product-gallery'>
        <div className="w-2/6 space-y-2 flex flex-col items-end pr-8  h-[50vh] overflow-y-auto">
          {gallery.map((image, index) => (
            <img
              onClick={()=> {this.setState({photoIndex: index})}}
              key={index}
              className={`w-[79px] h-[80px] cursor-pointer`}
              src={image}
              alt='picture'
            />
          ))}
        </div>
        <div className="w-4/6 flex items-center justify-center relative h-[50vh]">
          <div
            onClick={this.prevPhotoHandler}
            className="bg-black/70 p-1 pr-2 hover:bg-black/50 transition cursor-pointer absolute left-8"
          >
            <img src={leftArrow} className="w-6 h-8" alt="Previous" />
          </div>
          <div className="h-full">
            <img src={gallery[photoIndex]} className="h-full" alt={`Gallery image ${photoIndex}`} />
          </div>
          <div
            onClick={this.nextPhotoHandler}
            className="bg-black/70 p-1 pl-2 hover:bg-black/50 transition cursor-pointer absolute right-8">
            <img src={rightArrow} className="w-6 h-8" alt="Next" />
          </div>
        </div>
      </div>
    );
  }
}
