import React, { useEffect, useState } from 'react';
import axios from 'axios';

export default function Gallery() {
    const [images, setImages] = useState([]);
    const [image, setImage] = useState(null);

    useEffect(() => {
        fetchImages();

        window.Echo?.channel('gallery-channel')
            .listen('ImageUpdated', () => fetchImages());
    }, []);

    const fetchImages = async () => {
        const res = await axios.get('/api/gallery');
        setImages(res.data);
    };

    const upload = async () => {
        const form = new FormData();
        form.append('image', image);
        await axios.post('/api/gallery', form);
        setImage(null);
    };

    const remove = async (id) => {
        await axios.delete(`/api/gallery/${id}`);
    };

    return (
        <div style={{ padding: '20px' }}>
            <h2>Upload Image</h2>
            <input type="file" onChange={(e) => setImage(e.target.files[0])} />
            <button onClick={upload}>Upload</button>

            <div style={{ marginTop: '20px' }}>
                {images.map(img => (
                    <div key={img.id} style={{ marginBottom: '10px' }}>
                        <img src={`/storage/${img.image_path}`} width="150" />
                        <button onClick={() => remove(img.id)}>Delete</button>
                    </div>
                ))}
            </div>
        </div>
    );
}
