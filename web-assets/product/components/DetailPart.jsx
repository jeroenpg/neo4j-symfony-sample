/**
 *         _             __        __ _
 *   /\/\ (_) ___ __ _  / _\ ___  / _| |___      ____ _ _ __ ___
 *  /    \| |/ __/ _` | \ \ / _ \| |_| __\ \ /\ / / _` | '__/ _ \
 * / /\/\ \ | (_| (_| | _\ \ (_) |  _| |_ \ V  V / (_| | | |  __/
 * \/    \/_|\___\__,_| \__/\___/|_|  \__| \_/\_/ \__,_|_|  \___|
 * ----------------------------------------------
 * Copyright (c) 2017, Mica Software
 * All rights reserved.
 * ----------------------------------------------
 *
 * Created at: 11/12/2017
 * Created by: jeroen
 */

import React from 'react';
import PropTypes from 'prop-types'; // ES6
import ImageZoom from 'react-medium-image-zoom';
import { Part } from './Part';
import { Link } from 'react-router-dom';
import Masonry from 'react-masonry-component';

export class DetailPart extends React.Component {
    static propTypes = {
      part: PropTypes.object
    };

    relatedParts() {
      const { relatedParts } = this.props.part;

      return (relatedParts || []).map((part) => {
        return <Link key={part.id} to={ `/${part.id}` }><Part part={part}></Part></Link>;
      });
    }

    render() {
        if(!this.props.part) {
          return null;
        }

        var masonryOptions = {
          horizontalOrder: true,
          isFitWidth: true,
          gutter: 10
        };

        const { name, description, image, tag1, tag2, tag3, tag4 } = this.props.part;
        const imageSrc = image ? require('../../image/part/' + image) : require('../../image/no_category.png');

        return <div>
            <div style={{paddingLeft: 5}}>
              <div style={{ fontSize: 14, marginBottom: 10, color: "gray"}}>{ tag1 }{" > "}{ tag2 }{" > "}{ tag3 }{" > "}{ tag4 }</div>
              <div style={{ fontSize: 28, marginBottom: 10, marginTop: 20 }}>{ name }</div>
              <div style={{ marginBottom: 10 }}>{ description }</div>
              <div style={{ marginBottom: 10 }}><span style={{ paddingRight: 10 }}>Available Stock:</span>
                <img src={require('../../image/nl.png')} />
                <img src={require('../../image/se.png')} />
                <img src={require('../../image/fr.png')} />
                <img src={require('../../image/fi.png')} />
                <img src={require('../../image/es.png')} />
              </div>
              <ImageZoom
                image={{
                  src: imageSrc,
                  className: 'img',
                  style: { width: '275px' }
                }}
                zoomImage={{
                  src: imageSrc
                }}
                />
          </div>

          <div>
            <div style={{ fontSize: 20, marginBottom: 10, marginTop: 10, marginLeft: 10 }}>Related Parts</div>
            <Masonry className={'parts'} options={masonryOptions}>
              { this.relatedParts() }
            </Masonry>
          </div>
        </div>
    }
}
